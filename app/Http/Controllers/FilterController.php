<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Parameter;
use App\Models\Diamond;
use PHPUnit\Util\Exporter;

class FilterController extends Controller
{
    public function filter()
    {
        try {

            $minPrice = Diamond::min('Amount');
            $maxPrice = Diamond::max('Amount');

            $mincarat = Diamond::min('Carat');
            $maxcarat = Diamond::max('Carat');

            $mintable = Diamond::min('TableArea');
            $maxtable = Diamond::max('TableArea');

            $mintabledepth = Diamond::min('TableDepth');
            $maxtabledepth = Diamond::max('TableDepth');

            $return = [
                "shape" => [],
                "color" => [],
                "clarity" => [],
                "cut" => [],
                "polish" => [],
                "Lab" => [],
                "sym" => [],
                "amountprice" => [
                    [
                        "minprice" => $minPrice,
                        "maxprice" => $maxPrice,
                    ]
                ],
                "caratprice" => [
                    [
                        "minprice" => $mincarat,
                        "maxprice" => $maxcarat,
                    ]
                ],
                "tableareaprice" => [
                    [
                        "minprice" => $mintable,
                        "maxprice" => $maxtable,
                    ]
                ],
                "tabledepth" => [
                    [
                        "minprice" => $mintabledepth,
                        "maxprice" => $maxtabledepth,
                    ]
                ],
            ];

            $data = Parameter::select('ParaId', 'ParaName', "ParaTypeId")->whereIn('ParaTypeId', [1, 2, 3, 4, 5, 6, 8])->get();
            foreach ($data as $key => $value) {
                if ($value->ParaTypeId == 1) {
                    $return["shape"][] = array(
                        "Id" => $value->ParaId,
                        "Name" => $value->ParaName
                    );
                } elseif ($value->ParaTypeId == 2) {
                    $return["color"][] = array(
                        "Id" => $value->ParaId,
                        "Name" => $value->ParaName
                    );
                } elseif ($value->ParaTypeId == 3) {
                    $return["clarity"][] = array(
                        "Id" => $value->ParaId,
                        "Name" => $value->ParaName
                    );
                } elseif ($value->ParaTypeId == 4) {
                    $return["cut"][] = array(
                        "Id" => $value->ParaId,
                        "Name" => $value->ParaName
                    );
                } elseif ($value->ParaTypeId == 5) {
                    $return["polish"][] = array(
                        "Id" => $value->ParaId,
                        "Name" => $value->ParaName,
                    );
                } elseif ($value->ParaTypeId == 6) {
                    $return["sym"][] = array(
                        "Id" => $value->ParaId,
                        "Name" => $value->ParaName
                    );
                } elseif ($value->ParaTypeId == 8) {
                    $return["Lab"][] = array(
                        "Id" => $value->ParaId,
                        "Name" => $value->ParaName,
                    );
                }
            }
            return Response([
                'User' => $return,
                "status" => true,
                "message" => "Inserted Success",
            ]);
        } catch (\Throwable $th) {
            return Response([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
    public function diamond(Request $request)
    {
        try {
            $postData =  $request->all();
            $data = Diamond::where(function ($q) use ($postData) {
                if (isset($postData['colors'])) {
                    $q->whereIn('Color', $postData['colors']);
                }
                if (isset($postData['Carats'])) {
                    $q->whereIn('Carat', $postData['Carats']);
                };
                if (isset($postData['Claritys'])) {
                    $q->whereIn('Clarity', $postData['Claritys']);
                }
                if (isset($postData['Cuts'])) {
                    $q->whereIn('Cut', $postData['Cuts']);
                }
                if (isset($postData['Polishs'])) {
                    $q->whereIn('Polish', $postData['Polishs']);
                }
                if (isset($postData['Labs'])) {
                    $q->where('Lab', $postData['Labs']);
                }
                if (isset($postData['syms'])) {
                    $q->whereIn('sym', $postData['syms']);
                }
                if (isset($postData['Amountprice'])) {
                    $q->where('Amount', '>=', $postData['Amountprice'][0])
                        ->where('Amount', '<=', $postData['Amountprice'][1]);
                }
                if (isset($postData['Caratprice'])) {
                    $q->where('Carat', '>=', $postData['Caratprice'][0])
                        ->where('Carat', '<=', $postData['Caratprice'][1]);
                }
                if (isset($postData['Tableprice'])) {
                    $q->where('TableArea', '>=', $postData['Tableprice'][0])
                        ->where('TableArea', '<=', $postData['Tableprice'][1]);
                }
                if (isset($postData['TableAreaprice'])) {
                    $q->where('TableDepth', '>=', $postData['TableAreaprice'][0])
                        ->where('TableDepth', '<=', $postData['TableAreaprice'][1]);
                }

                return $q;
            })
                ->with(['LabName', 'ShapeName', 'ColorName', 'ClarityName', 'CutName', 'PolishName', 'SymName'])->paginate(10);

            return response([
                'data' => $data,
                'status' => true,
                'message' => $postData,
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
