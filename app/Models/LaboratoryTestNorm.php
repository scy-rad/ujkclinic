<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryTestNorm extends Model
{
  use HasFactory;

  protected $fillable = [
    'laboratory_test_id',
    'ltn_days_from',
    'ltn_days_to',
    'ltn_norm_type',
    'ltn_norm_m_min',
    'ltn_norm_m_max',
    'ltn_norm_w_min',
    'ltn_norm_w_max',
    'ltn_norm_p_min',
    'ltn_norm_p_max',
    'ltn_decimal_prec',
    'ltn_unit',
    'ltn_unit_en'
    ]; 

  public function laboratory_test()
  {
    return $this->hasOne(LaboratoryTest::class, 'id', 'laboratory_test_id');
  }

  function write_range()
  {
    $lang="pl";

    if ($lang=="pl")
    {
      $days = 'd.';
      $years = 'l.';
    }
    if ($lang=="en")
    {
      $days = 'd.';
      $years = 'y.';
    }

    $ret='';

    $something=$this->ltn_days_from;

    if ($something==0)
      $ret.='≤ ';
    else
    {
      if (($something % 365 == 0) || ($something % 365 == 1) )
        $ret .= (($something-($something % 365))/365)." ".$years;
      else 
        $ret .= $something." ".$days;
    }
      
    $something=$this->ltn_days_to;

    if ($something==(120*365))
      $ret='> '.$ret;
    else
    {
      if ($this->ltn_days_from>0)
        $ret .= ' - ';
      if (($something % 365 == 0) || ($something % 365 == 1) )
        $ret .= (($something-($something % 365))/365)." ".$years;
      else 
        $ret .= $something." ".$days;
    }

    return $ret;
  }

  function write_norm()
  {
    $lang="pl";

    if ($lang=="pl")
    {
      $man = 'M';
      $woman = 'K';
      $pregnant = 'KwC';
    }
    if ($lang=="en")
    {
      $man = 'M';
      $woman = 'W';
      $pregnant = 'WiP';
    }
    if ( ($this->ltn_norm_m_min == $this->ltn_norm_w_min) && ($this->ltn_norm_m_min == $this->ltn_norm_p_min) &&
         ($this->ltn_norm_m_max == $this->ltn_norm_w_max) && ($this->ltn_norm_m_max == $this->ltn_norm_p_max) )
    {
      $same=true;
    }
    else 
    {
      $same=false;
    }
    if ($this->ltn_decimal_prec==0) dd($this);
      $ret='';
    switch ($this->ltn_norm_type)
    {
      case 1 : // mniej niż MAX
        $ret= '< ';          
      case 2 : // mniej niż MAX lub równo 
        if ($ret!= '< ')     
          $ret= '≤ ';
        if ($same) 
          $ret .= ($this->ltn_norm_m_max/$this->ltn_decimal_prec);
        else
        {
          if (!is_null($this->ltn_norm_m_max))
            $ret .= $man.": ".($this->ltn_norm_m_max/$this->ltn_decimal_prec).'; ';
          if (!is_null($this->ltn_norm_w_max))
            $ret .= $woman.": ".($this->ltn_norm_w_max/$this->ltn_decimal_prec).'; ';
          if ( (!is_null($this->ltn_norm_p_max)) &&  ($this->ltn_norm_w_max!=$this->ltn_norm_p_max) )
            $ret .= $pregnant.": ".($this->ltn_norm_p_max/$this->ltn_decimal_prec).'; ';
        }
      break;
      case 3 : // zakres od do 
        if ($same)           
          $ret .= ($this->ltn_norm_m_min/$this->ltn_decimal_prec).' - '.($this->ltn_norm_m_max/$this->ltn_decimal_prec);
        else
        {
          if (!is_null($this->ltn_norm_m_min))
            $ret .= $man.": ".($this->ltn_norm_m_min/$this->ltn_decimal_prec).' - '.($this->ltn_norm_m_max/$this->ltn_decimal_prec).'; ';
          if (!is_null($this->ltn_norm_w_min))
            $ret .= $woman.": ".($this->ltn_norm_w_min/$this->ltn_decimal_prec).' - '.($this->ltn_norm_w_max/$this->ltn_decimal_prec).'; ';
          if ( (!is_null($this->ltn_norm_p_min)) && ( ($this->ltn_norm_w_min!=$this->ltn_norm_p_min) || ($this->ltn_norm_w_max!=$this->ltn_norm_p_max) ) )
            $ret .= $pregnant.": ".($this->ltn_norm_p_min/$this->ltn_decimal_prec).' - '.($this->ltn_norm_p_max/$this->ltn_decimal_prec).'; ';
        }
      break;
      case 4 : 
        $ret = 'więcej lub równo MAX';
      break;
      case 5 : 
        $ret = 'więcej niż MAX';
      break;
      case 6 : 
        $ret = 'wynik opisowy ';
      break;
    }
    return $ret;
  }
}
