<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Record;
use app\index\model\User;
use app\index\model\Book;
use app\index\model\Chucang;
use think\Request;
use think\Db;
use think\Session;

class RecordController extends Controller
{
	public function index($id)
	{
		// $data = Db::query('select re.id,re.date,re.redate,re.lastdate,re.user_id,re.book_id,re.chucang_id,b.bookname from record as re join book as b on re.book_id = b.id where user_id = '.$id.' order by date desc');
		$data = Record::all(function($query) use($id){
			$query->where('user_id','=',$id)
			->order('date', 'desc');
		    });
		$single = Record::where('user_id',$id)->find();
		$authority = Session::get('authority');
		$this->assign('authority',$authority);
		$username = Session::get('username');
		$this->assign('username',$username);
		if($single){
			$this->assign('single',$single);
		}else{
			$single = User::where('id',$id)->find();
			$this->assign('single',$single);
			return $this->fetch('record/nothing');
		}
		$this->assign('result',$data);
		return $this->fetch();
	}
	public function addrecord($user_id,$book_id)
	{
		$data = Book::where('id',$book_id)->find();
		$single = Record::where('redate','null')
		->where('user_id',$user_id)
		->find();
		$authority = Session::get('authority');
		$this->assign('authority',$authority);
		if($single){
			echo '把上一本还了再借！<br>';
			return '<a href="/book">返回</a>';
		}else{
			$this->assign('result',$data);
			$this->assign('user_id',$user_id);
			return $this->fetch();
		}
	}
	public function addr(Request $request)
	{
		$single = Chucang::where('book_id',$request->post('book_id'))
		->where('state',0)
		->find();
		if($single){
			$record = new Record;
			$record->date = date("Y-m-d H:i:s");
			$record->lastdate = date('Y-m-d H:i:s',strtotime("+7 day"));
			$record->user_id = $request->post('user_id');
			$record->book_id = $request->post('book_id');
			$record->chucang_id = $single->id;
			$single->state = 1;
			$single->save();
			if ($record->save()) {
				return $this->fetch('success/bosuccess');
			} else {
				return $record->getError();
			}
		}else{
			$single = Record::where('redate','null')
			->order('lastdate','asc')
			->find();
			$this->assign('single',$single);
			return $this->fetch('record/fail');
		}
	}
	public function rebook(Request $request,$id,$book_id)
	{
		$data = Book::where('id',$book_id)->find();
		$authority = Session::get('authority');
		$this->assign('authority',$authority);
		$this->assign('result',$data);
		$this->assign('id',$id);
		$this->assign('chucang_id',$request->post('chucang_id'));
		return $this->fetch();
	}
	public function reb(Request $request)
	{
		$record = Record::get($request->post('id'));
		$record->redate = date("Y-m-d H:i:s");
		$chucang = Chucang::where('id',$request->post('chucang_id'))->find();
		if($chucang){
			$chucang->state = 0;
			if($chucang->save() && $record->save()){
				return $this->fetch('success/resuccess');
			}else{
				return $chucang->getError();
			}
		}else{
			return $chucang->getError();
		}
	}
	public function view()
	{
		$data = User::where('authority',2)->select();
		$authority = Session::get('authority');
		$this->assign('authority',$authority);
		$this->assign('result',$data);
		return $this->fetch();
	}
	public function viewall()
	{
		$data = Record::all(function($query){
			$query->order('date', 'desc');
		    });
		$authority = Session::get('authority');
		$this->assign('authority',$authority);
		$username = Session::get('username');
		$this->assign('username',$username);
		$this->assign('result',$data);
		return $this->fetch();
	}
	public function details($id)
	{
		$data = Record::where('book_id',$id)->select();
		$single = Record::where('book_id',$id)->find();
		$authority = Session::get('authority');
		$this->assign('authority',$authority);
		$username = Session::get('username');
		$this->assign('username',$username);
		if($single){
			$this->assign('single',$single);
		}else{
			return $this->fetch('record/nothingbook');
		}
		$this->assign('result',$data);
		return $this->fetch();
	}
}
