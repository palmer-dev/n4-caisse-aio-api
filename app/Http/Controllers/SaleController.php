<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Http\Requests\ComputeSaleRequest;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use App\Mail\SaleReceiptMail;
use App\Models\Sale;
use App\Models\Scopes\ByShop;
use App\Models\Sku;
use App\Services\ReceiptService;
use App\Services\SaleTotalRefresher;
use App\Services\SimulationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SaleController extends Controller
{
    use AuthorizesRequests;


    public function __construct(protected SaleTotalRefresher $saleTotalRefresher, protected ReceiptService $receiptService, protected SimulationService $simulationService)
    {
    }

    public function index()
    {
        $this->authorize( 'viewAny', Sale::class );

        $sales = Sale::with( ["shop"] )
            ->when( auth()->user()->hasRole( RolesEnum::CLIENT ), function ($query) {
                $query->withoutGlobalScope( ByShop::class )
                    ->whereHas( 'client', function ($query) {
                        $query->where( 'user_id', auth()->id() );
                    } );
            } )
            ->get();

        return SaleResource::collection( $sales );
    }

    public function store(SaleRequest $request)
    {
        $this->authorize( 'create', Sale::class );

        try {
            return DB::transaction( function () use ($request) {
                $sale = Sale::create( [
                        'shop_id' => auth()->user()->shop_id,
                        ...$request->validated()
                    ]
                );

                $detailsFromRequest = collect( $request->validated( 'skus' ) );

                $skus = Sku::whereIn( 'sku', $detailsFromRequest->pluck( 'sku' ) )
                    ->with( ['product', 'product.vatRate'] )
                    ->get()
                    ->keyBy( 'sku' );

                $details = $detailsFromRequest->map( function ($detail) use ($skus) {
                    /**
                     * @var $sku Sku
                     */
                    $sku = $skus->get( $detail['sku'] );

                    if (!$sku) {
                        throw new \Exception( "SKU non trouvé : {$detail['sku']}" );
                    }

                    return [
                        'sku_id'     => $sku->id,
                        'quantity'   => $detail['quantity'],
                        'vat'        => $sku->product->vatRate->value,
                        'unit_price' => $sku->unit_amount,
                    ];
                } );

                $sale->details()->createMany( $details->toArray() );

                $this->saleTotalRefresher->refresh( $sale );

                return new SaleResource( $sale );
            } );
        } catch (\Throwable $e) {
            report( $e ); // log ou sentry
            return response()->json( ['message' => 'Erreur lors de la création de la vente.'], 500 );
        }
    }

    public function show(Sale $sale)
    {
        $this->authorize( 'view', $sale );

        $sale->load( ["shop"] );

        return new SaleResource( $sale );
    }

    public function update(SaleRequest $request, Sale $sale)
    {
        $this->authorize( 'update', $sale );

        $sale->update( $request->validated() );

        return new SaleResource( $sale );
    }

    public function destroy(Sale $sale)
    {
        $this->authorize( 'delete', $sale );

        $sale->delete();

        return response()->json();
    }

    public function generateTicket(Sale $sale)
    {
        $this->saleTotalRefresher->refresh( $sale );

        $file = $this->receiptService->getReceipt( $sale, true );

        return response()->file( $file );
    }

    public function previewReceipt(Sale $sale)
    {
        $file = $this->receiptService->getReceipt( $sale );

        return response()->file( $file );
    }

    public function compute(ComputeSaleRequest $request)
    {
        $this->authorize( 'create', Sale::class );

        $result = $this->simulationService->compute( $request->validated( "skus" ) );

        return response()->json( [
            'data' => $result
        ] );
    }

    public function sendReceipt(Sale $sale)
    {
        $this->authorize( 'view', $sale );

        $file = $this->receiptService->getReceipt( $sale );

        Mail::to( $sale->client->email )->send( new SaleReceiptMail( $sale, $file ) );

        return response()->noContent();
    }
}
