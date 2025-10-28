<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index(Request $request){
         $users = User::all();

             // Si c'est une requête API
    if (request()->wantsJson() || request()->is('api/*')) {
        return response()->json([
            'success' => true,
            'data' => $users
        ]); }


        

        $query = User::query();
        if(request()->has("search") && $request->search){
            $query = $query->where("nom","like","%".$request->search."%")
                        ->orWhere('prenom','like',"%".$request->search."%");
        }
        $users = $query->latest()->paginate(8);

        return view("user.user-list",compact("users"));
    }
 public function create(){
       
        return view("user.create");
    }
  

   public function store(Request $request)
{

    try {

            // dd($request->all()); // pour tester les donne À supprimer après test

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string|max:20',
            'password' => 'required|min:8',
            'role' => 'required|in:ADMIN,USER,MANAGER', // En majuscules
            'statut' => 'required|in:Active,Inactive' 
        ]);

             // Voir les données validées
        // dd($validated); // pour tester les donne À supprimer après test

        // Hash du mot de passe
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route("user.index")->with("success", "Utilisateur ajouté avec succès");

    } catch (\Exception $e) {
        //  dd($e->getMessage()); // pour tester les donne  Voir l'erreur exacte
        return redirect()->back()->withInput()->with("error", "Erreur lors de la création : " . $e->getMessage());
        
    }
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

    public function destroy($id){
       User::find($id)->delete();
        return redirect()->route("user.index")->with("success","user deleted successfully!");
    }

    public function trashedUsers(Request $request){
        $query =User::query()->onlyTrashed();
        if(request()->has("search") && $request->search){
            $query = $query->where("name","like","%".$request->search."%")
                        ->orWhere('description','like',"%".$request->search."%");
        }
        $users = $query->paginate(5);
        return view("user.deleted-users",compact("users"));
    }

    public function showTrashed($id){
        $user =User::onlyTrashed()->findOrFail($id);
        return view("user.show",compact("user"));
    }

    public function restoreProduct($id){
        $user =User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route("user.index")->with("success","user restored successfully");
    }

    public function destroyProduct($id){
        $user =User::onlyTrashed()->findOrFail($id);
        if ($user->image && Storage::exists($user->image)) {
            Storage::delete($user->image);
        }
        $user->forceDelete();

        return redirect()->route("user.index")->with("success","user was force deleted successfully!");
    }

}