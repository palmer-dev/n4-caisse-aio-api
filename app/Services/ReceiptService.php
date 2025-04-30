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

    public function getReceipt(Sale $sale): string
    {
        $this->file = $this->getReceiptFolder( $sale );

        if (!Storage::exists( $this->file )) {
            $this->generatePDF( $sale );
        }

        return Storage::path( $this->file );
    }

    public function generatePDF(Sale $sale): void
    {
        $products = $sale->details->map( function (SaleDetail $item) {
            return [
                'name'  => $item->denomination,
                'qty'   => $item->quantity,
                'price' => $item->grandTotal,
            ];
        } );
        $data     = [
            'store_name' => $sale->shop->name,
            'address'    => $sale->shop->primaryAddress?->line,
            'sale_no'    => $sale->sale_no,
            'date'       => now(),
            'items'      => $products,
            'total'      => $products->sum( 'price' ),
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
        $dompdf->setPaper( array(0, 0, 204, $GLOBALS['bodyHeight'] + 10) );
        $dompdf->setOptions( new Options( ['dpi' => 72] ) );
        $dompdf->loadHtml( $html );
        $dompdf->render();

        Storage::put( $this->getReceiptFolder( $sale ), $dompdf->output() );
    }
}
