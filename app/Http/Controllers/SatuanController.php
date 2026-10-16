<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
class SatuanController extends Controller
{
public function index()
{
$satuan = DB::select('SELECT * FROM satuan_vu');
return view('satuan.index', ['satuan' => $satuan]);
}
}