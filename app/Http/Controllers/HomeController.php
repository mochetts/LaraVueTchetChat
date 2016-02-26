<?php namespace App\Http\Controllers;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$swID = rand(1, 87);
		$swChar = json_decode(file_get_contents('https://swapi.co/api/people/'.$swID.'/'));
		$userName = $swChar->name;

		$chatPort = \Request::input("p");
		$chatPort = $chatPort ?: 9090;
		return view('home', compact("chatPort", "userName"));
	}

}
