<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diamond extends Model
{
    use HasFactory;
    protected $table = 'tbl_diamond_master';

    public function LabName()
    {
        return $this->belongsTo(Parameter::class, 'Lab', 'ParaId')->select('ParaId', 'ParaName');
    }
    public function ShapeName()
    {
        return $this->belongsTo(Parameter::class, 'Shape', 'ParaId')->select('ParaId', 'ParaName');
    }                                                                                                                                                                               
    public function ColorName()
    {
        return $this->belongsTo(Parameter::class, 'Color', 'ParaId')->select('ParaId', 'ParaName');
    }
    public function ClarityName()
    {
        return $this->belongsTo(Parameter::class, 'Clarity', 'ParaId')->select('ParaId', 'ParaName');
    }
    public function CutName()
    {
        return $this->belongsTo(Parameter::class, 'Cut', 'ParaId')->select('ParaId', 'ParaName');
    }
    public function PolishName()
    {
        return $this->belongsTo(Parameter::class, 'Polish', 'ParaId')->select('ParaId', 'ParaName');
    }
    public function SymName()
    {
        return $this->belongsTo(Parameter::class, 'Sym', 'ParaId')->select('ParaId', 'ParaName');
    }
}
