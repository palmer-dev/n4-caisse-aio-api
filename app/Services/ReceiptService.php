<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SaleDetail;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;

class ReceiptService
{
    private string $file = "";

    public function getReceiptFolder(Sale $sale): string
    {
        return 'pdf-receipt/' . $sale->shop_id . '/' . mb_strtolower( $sale->sale_no ) . '.pdf';
    }

    public function getReceipt(Sale $sale, bool $forceRegeneration = false): string
    {
        $this->file = $this->getReceiptFolder( $sale );

        if ($forceRegeneration || !Storage::exists( $this->file )) {
            $this->generatePDF( $sale );
        }

        return Storage::path( $this->file );
    }

    public function generatePDF(Sale $sale): void
    {
        $products = $sale->details->map( function (SaleDetail $item) {
            return [
                'name'       => $item->denomination,
                'qty'        => $item->quantity,
                'vat'        => $item->vat,
                'vat_amount' => $item->vat_amount,
                'price'      => $this->formatCurrency( $item->grand_total ),
            ];
        } );

        $taxBreakdown = collect( [] );

        $products->each( function ($sku) use (&$taxBreakdown) {
            $vatRate = $sku['vat'];

            if (!isset( $taxBreakdown[$vatRate] )) {
                $taxBreakdown[$vatRate] = 0;
            }

            $taxBreakdown[$vatRate] += $sku['vat_amount'];
        } );

        $taxBreakdown->each( function ($amount, $vatRate) use (&$taxBreakdown) {
            $taxBreakdown[$vatRate] = $this->formatCurrency( $amount );
        } );

        $data = [
            'store_name'     => $sale->shop->name,
            'address'        => $sale->shop->primaryAddress?->line,
            'siret'          => $sale->shop->siret ?? 'XXXXXXXXXXXXX',
            'rcs'            => $sale->shop->rcs ?? 'RCS Ville B 123 456 789',
            'sale_no'        => $sale->sale_no,
            'date'           => $sale->created_at->format( 'd/m/Y' ),
            'time'           => $sale->created_at->format( 'H:i' ),
            'items'          => $products,
            'total'          => $this->formatCurrency( $sale->grand_total ),
            'total_ht'       => $this->formatCurrency( $sale->sub_total ),
            'tax_breakdown'  => $taxBreakdown,
            'payment_method' => $sale->payment_method->label(),
            'has_discount'   => $sale->discount > 0,
            'discount'       => $this->formatCurrency( $sale->discount ?? 0 ),
            'tva_exempt'     => $sale->shop->is_tva_exempt ?? false,
        ];


        $html = view( 'pdf.ticket', $data )->render();

        $dompdf = new Dompdf();
        $dompdf->setPaper( array(0, 0, 204, 800) );
        $dompdf->setOptions( new Options( ['dpi' => 72] ) );

        $GLOBALS['bodyHeight'] = 0;

        $dompdf->setCallbacks( [
            'myCallbacks' => [
                'event' => 'end_frame',
                'f'     => function ($frame) {
                    $node = $frame->get_node();

                    if (strtolower( $node->nodeName ) === "body") {
                        $padding_box           = $frame->get_padding_box();
                        $GLOBALS['bodyHeight'] += $padding_box['h'];
                    }
                }
            ]
        ] );

        $dompdf->loadHtml( $html );
        $dompdf->render();
        unset( $dompdf );

        $dompdf = new Dompdf();
        $dompdf->setPaper( array(0, 0, 204, $GLOBALS['bodyHeight'] + 20) );
        $dompdf->setOptions( new Options( ['dpi' => 72] ) );
        $dompdf->loadHtml( $html );
        $dompdf->render();

        Storage::put( $this->getReceiptFolder( $sale ), $dompdf->output() );
    }

    private function formatCurrency(float $amount, $currency = 'EUR'): string
    {
        return \NumberFormatter::create( app()->getLocale(), \NumberFormatter::CURRENCY_ACCOUNTING )->formatCurrency( $amount, $currency );
    }
}
