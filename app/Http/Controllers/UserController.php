<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
class UserController extends Controller
{
    public function index(Request $request){
        // user = User::all();
        $query = User::query();
        if(request()->has("search") && $request->search){
            $query = $query->where("nom","like","%".$request->search."%")
                        ->orWhere('prenon','like',"%".$request->search."%");
        }
        $users = $query->latest()->paginate(8);

        return view("user.user-list",compact("users"));
    }
 public function create(){
       
        return view("user.create");
    }
  

    public function store(Request $request){
        $validated = $request->validate([
             'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'statut' => 'required|string',
            // 'email_verified_at'=> 'timestamp|date',
           
        //    'date_inscription' => 'timestamp|date',
            //   "created_at"=> "required",
            //    "updated_at"=> "required",


            ]);
           
            User::create($validated);

            return redirect()->route("user.index")->with("success","user added successfully");
        }

        public function show($id){
            $user = User::find($id);
            return view("user.show",compact("user"));
        }

        public function edit($id){
           
            $user = User::find($id);
            return view("user.edit",compact("user","id"));
        }

        public function update(Request $request, $id){
                $validated = $request->validate([
                    "nom"=> "required|string",
                    "prenom"=> "required|string",
                    "email"=> "required|string|email|unique:users",
                    "telephone"=> "required|numeric",
                    "password"=> "required|string",
                    "role"=> "required",
                    "statut"=> "required",
                    //   "created_at"=> "required",
                    //    "updated_at"=> "required",
                 ]);

              
                  

                User::find($id)->update($validated);

                return redirect()->route("user.index")->with("success","user updated successfully!");
}

//     public function destroy($id){
//         Product::find($id)->delete();
//         return redirect()->route("product.index")->with("success","product deleted successfully!");
//     }

//     public function trashedProducts(Request $request){
//         $query = Product::query()->onlyTrashed();
//         if(request()->has("search") && $request->search){
//             $query = $query->where("name","like","%".$request->search."%")
//                         ->orWhere('description','like',"%".$request->search."%");
//         }
//         $products = $query->paginate(5);
//         return view("product.deleted-products",compact("products"));
//     }

//     public function showTrashed($id){
//         $product = Product::onlyTrashed()->findOrFail($id);
//         return view("product.show",compact("product"));
//     }

//     public function restoreProduct($id){
//         $product = Product::onlyTrashed()->findOrFail($id);
//         $product->restore();
//         return redirect()->route("product.index")->with("success","product restored successfully");
//     }

//     public function destroyProduct($id){
//         $product = Product::onlyTrashed()->findOrFail($id);
//         if ($product->image && Storage::exists($product->image)) {
//             Storage::delete($product->image);
//         }
//         $product->forceDelete();

//         return redirect()->route("product.index")->with("success","product was force deleted successfully!");
//     }

}