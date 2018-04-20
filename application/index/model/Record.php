<?php
namespace app\index\model;
use think\Model;
class Record extends Model
{
	public function user()
	{
		return $this->belongsTo('user');
	}
	public function book()
	{
		return $this->belongsTo('book');
	}
	public function chucang()
	{
		return $this->belongsTo('chucang');
	}
}