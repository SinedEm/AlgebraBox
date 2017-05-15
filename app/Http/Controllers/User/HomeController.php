<?php
namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use App\Models\UsersRoot;
use Storage;
class HomeController extends Controller
{
	
	private $user_id;
	private $root_name = false;
  /**
   * Set middleware to quard controller.
   *
   * @return void
   */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$this->setRoot();
		
		if($this->root_name) {
			$allDir = Storage::disk('public')->directories($this->root_name);
			$files = Storage::disk('public')->files($this->root_name);
			
			return view('user.home', ['directories' => $allDir, 'files' => $files]);
		}
		
		return view('user.home',['directories' => false, 'files' => false]);
        
    }
	
	public function create(Request $request)
	{
		$this->setRoot();
		
		$dir_name = trim($request->get('dir_name'));
        if(!empty($dir_name)) {
			Storage::disk('public')->makeDirectory($this->root_name.'/'.$dir_name);
		}
		return redirect()->route('home');
	}
	private function setRoot()
	{
		$this->user_id = Sentinel::getUser()->id;
		$root = UsersRoot::where('user_id', $this->user_id)->first();
		if($root) {
			$this->root_name = $root->name;
		}
	}
}

