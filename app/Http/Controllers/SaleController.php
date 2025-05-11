<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComputeSaleRequest;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use App\Models\Sku;
use App\Services\ReceiptService;
use App\Services\SaleTotalRefresher;
use App\Services\SimulationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SaleController extends Controller
{
    use AuthorizesRequests;


    public function __construct(protected SaleTotalRefresher $saleTotalRefresher, protected ReceiptService $receiptService, protected SimulationService $simulationService)
    {
    }

    public function index()
    {
        $this->authorize( 'viewAny', Sale::class );

        return SaleResource::collection( Sale::all() );
    }

    public function store(SaleRequest $request)
    {
        $this->authorize( 'create', Sale::class );

        $sale = Sale::create( $request->validated() );

        $detailsFromRequest = collect( $request->validated( 'skus' ) );

        // Récupère les Skus existants depuis la base, indexés par code SKU
        $skus = Sku::whereIn( 'sku', $detailsFromRequest->pluck( 'sku' ) )
            ->get()
            ->keyBy( 'sku' ); // Permet un accès direct via le code SKU

        $details = $detailsFromRequest->map( function ($detail) use ($skus) {
            $sku = $skus->get( $detail['sku'] );

            if (!$sku) {
                throw new \Exception( "SKU non trouvé : {$detail['sku']}" );
            }

            return [
                'sku_id'     => $sku->id,
                'quantity'   => $detail['quantity'],
                'vat'        => $sku->product->vatRate->rate,
                'unit_price' => $sku->unit_price, // Take the price from the model, multiply by hundred to have the price in cents
            ];
        } );

        // Création en masse des SaleDetails
        $sale->details()->createMany( $details->toArray() );

        $this->saleTotalRefresher->refresh( $sale );

        return new SaleResource( $sale );
    }

    public function show(Sale $sale)
    {
        $this->authorize( 'view', $sale );

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

        $file = $this->receiptService->getReceipt( $sale );

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
}
