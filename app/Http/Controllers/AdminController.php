<?php

namespace App\Http\Controllers;

use Image;
use App\City;
use App\User;
use App\Admin;
use App\Bearer;
use App\Location;
use App\Restaurant;
// use Faker\Provider\Image;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.home');
    }

    public function getAllAdmins()
    {
        $admins = Admin::latest()->get();

        return response()->json($admins, 200);
    }

    public function getAdmin($id)
    {
        $admin = Admin::findOrFail($id);

        return response()->json($admin, 200);
    }
    

    public function disableAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->update([
            $admin->status = 0
        ]);

        return response()->json($admin, 200); 
    }

    public function enableAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->update([
            $admin->status = 1
        ]);

        return response()->json($admin, 200); 
    }

    public function updateAdminDetails(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $this->validate($request, [
            'update.fullname' => 'required|max:60',
            'update.phone' => 'required|numeric'
        ]);

        $admin->update([
            $admin->fullname = $request->update['fullname'],
            $admin->phone = $request->update['phone']
        ]);

        return response()->json($admin, 200); 
    }

    public function updateAdminPswd(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $this->validate($request, [
            'password' => 'required|min:5|max:15',
        ]);

        $update = $admin->update([
            $admin->password = Bcrypt($request->password)
        ]);

        if($update){
            return response()->json($admin, 200);
        }
    }

    public function createNewAdmin(Request $request)
    {
        // print_r($request->all());
        $this->validate($request, [
            'admin.fullname' => 'required|max:60',
            'admin.email'=> 'required|string|email|max:255|unique:admins,email',
            'admin.phone' => 'required|numeric',
            'admin.status' => 'required'
        ]);

        $admin = new Admin;
        $admin->fullname = $request->admin['fullname'];
        $admin->email = $request->admin['email'];
        $admin->phone = $request->admin['phone'];
        $admin->role = 7;
        $admin->status = $request->admin['status'];
        $admin->password = null;
        $admin->save();

        return response()->json($admin, 200);
    }

    public function delAdmin($id)
    {
        $admin = Admin::findOrFail($id);

        $del = $admin->delete();

        return response()->json(['message' => 'deleted', 200]);
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $this ->validate($request, [
            'admin.fullname' => 'required|max:60',
            'admin.phone' => 'required|numeric'
        ]);

        // print_r($request->all());
        $admin->update([
            $admin->fullname = $request->admin['fullname'],
            $admin->phone = $request->admin['phone'],
        ]);

        return response()->json($admin, 200);
    }

    public function getAllBearers()
    {
        $bearers = Bearer::latest()->get();

        return response()->json($bearers, 200);
    }

    public function createNewBearer(Request $request)
    {
        $this->validate($request, [
            'bearer.fullname' => 'required|max:60',
            'bearer.email'=> 'required|string|email|max:255|unique:bearers,email',
            'bearer.phone' => 'required|numeric',
            'bearer.status' => 'required'
        ]);

        $bearer = new Bearer;
        $bearer->fullname = $request->bearer['fullname'];
        $bearer->email = $request->bearer['email'];
        $bearer->phone = $request->bearer['phone'];
        $bearer->role = 5;
        $bearer->status = $request->bearer['status'];
        $bearer->password = null;
        $bearer->save();

        return response()->json($bearer, 200);
    }

    public function deleteBearer($id)
    {
        $bearer = Bearer::findOrFail($id);

        $del = $bearer->delete();

        return response()->json(['message' => 'deleted', 200]);
    }

    public function updateBearerDetails(Request $request, $id)
    {
        $bearer = Bearer::findOrFail($id);

        $this->validate($request, [
            'bearer.fullname' => 'required|max:60',
            'bearer.phone' => 'required|numeric'
        ]);

        $bearer->update([
            $bearer->fullname = $request->bearer['fullname'],
            $bearer->phone = $request->bearer['phone']
        ]);

        return response()->json($bearer, 200); 
    }

    public function getBearer($id)
    {
        $bearer = Bearer::findOrFail($id);

        return response()->json($bearer, 200);
    }

    public function disableBearer($id)
    {
        $bearer = Bearer::findOrFail($id);

        $bearer->update([
            $bearer->status = 0
        ]);

        return response()->json($bearer, 200); 
    }

    public function enableBearer($id)
    {
        $bearer = Bearer::findOrFail($id);

        $bearer->update([
            $bearer->status = 1
        ]);

        return response()->json($bearer, 200); 
    }

    public function updateBearer(Request $request, $id)
    {
        $bearer = Bearer::findOrFail($id);

        $this->validate($request, [
            'update.fullname' => 'required|max:60',
            'update.phone' => 'required|numeric'
        ]);

        $bearer->update([
            $bearer->fullname = $request->update['fullname'],
            $bearer->phone = $request->update['phone']
        ]);

        return response()->json($bearer, 200);
    }


    public function updateBearerPswd(Request $request, $id)
    {
        $bearer = Bearer::findOrFail($id);

        $this->validate($request, [
            'password' => 'required|min:5|max:15',
        ]);

        $update = $bearer->update([
            $bearer->password = Bcrypt($request->password)
        ]);

        if($update){
            return response()->json($bearer, 200);
        }
    }

    public function getAllUsers()
    {
        $users = User::latest()->get();

        return response()->json($users, 200);
    }

    public function createNewUser(Request $request)
    {    
        $this->validate($request, [
            'user.fullname' => 'required|max:60',
            'user.email'=> 'required|string|email|max:255|unique:users,email',
            'user.phone' => 'required|numeric',
            'user.address' => 'required|max:120',
            'user.location' => 'required',
            'user.status' => 'required'
        ]);

        $user = new User;
        $user->name = $request->user['fullname'];
        $user->email = $request->user['email'];
        $user->phone = $request->user['phone'];
        $user->address = $request->user['address'];
        $user->location_id = $request->user['location'];
        $user->status = 0;
        $user->password = bcrypt('password');
        $user->save();

        return response()->json($user, 200);
    }

    public function getAllLocations()
    {
        $locations = Location::orderBy('name')->get();

        return response()->json($locations, 200);
    }

    public function delClientUser($id)
    {
        $del = User::findOrFail($id)->delete();

        if($del){
            return response()->json(['message' => 'deleted', 200]);
        }
    }

    public function updateClientUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'user.fullname' => 'required|max:60',
            'user.phone' => 'required|numeric',
            // 'user.alt_phone' => 'numeric',
            'user.address' => 'required|max:120',
            'user.location' => 'required'
        ]);

        $user->update([
            $user->name = $request->user['fullname'],
            $user->phone = $request->user['phone'],
            $user->alt_phone = $request->user['alt_phone'],
            $user->address = $request->user['address'],
            $user->location_id = $request->user['location']
        ]);

        return response()->json($user, 200); 
    }

    public function getClientUser($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user, 200);
    }

    public function disableUser($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            $user->status = 0
        ]);

        return response()->json($user, 200); 
    }

    public function enableUser($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            $user->status = 1
        ]);

        return response()->json($user, 200);
    }

    public function changeUserPswd(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'password' => 'required|min:5|max:30',
        ]);

        $update = $user->update([
            $user->password = Bcrypt($request->password)
        ]);

        if($update){
            return response()->json($user, 200);
        }
    }

    public function getAllOutlets()
    {
        $outlets = Restaurant::latest()->get();

        return response()->json($outlets->load('city'), 200);
    }

    public function getAllCities()
    {
        $cities = City::latest()->get();

        return response()->json($cities->load(['location', 'restaurant']), 200);
    }

    public function getLocationFromCity($id)
    {
        $locations = Location::where('city_id', $id)->get();

        return response()->json($locations, 200);
    }

    public function createNewOutlet(Request $request)
    {
        $this->validate($request, [
            'city' => 'required',
            'location' => 'required',
            'name' => 'required|max:100',
            'phone' => 'required|numeric',
            'address' => 'required|max:200',
            'openingHr' => 'required',
            'closingHr' => 'required',
            'pic' => 'mimes:jpeg,jpg,bmp,png,gif,pdf',
        ]);

        // extract file
        if($request->file){
            $file = $request->file;
            $OriginalName = $file->getClientOriginalName();
            $exp_name = explode('.', $OriginalName); 
            $ext = $file->getClientOriginalExtension();
            $pool = '0123456789abcdefghijklmnopqrstuvwxyz@&';
            $filename = substr(str_shuffle($pool), 0, 8).".".$ext;
            //save new file in folder
            $file_loc = public_path('/images/assets/outlets/'.$filename);
            if(in_array($ext, ['jpeg', 'jpg', 'png', 'gif', 'pdf'])){
                $upload = Image::make($file)->resize(225, 225, function($constraint){
                    $constraint->aspectRatio();
                });
                $upload->sharpen(2)->save($file_loc);
            }
        }
        $outlet = new Restaurant;
        $outlet->city_id = $request->city;
        $outlet->loc_code = $request->location;
        $outlet->name = $request->name;
        $outlet->phone = $request->phone;
        $outlet->address = $request->address;
        $outlet->opening_hr = $request->openingHr;
        $outlet->closing_hr = $request->closingHr;
        if($request->file){
            $outlet->picture = $filename;
        }else{
            $outlet->picture = null;
        }

        $outlet->save();

        return response()->json($outlet->load('city'), 200);
    }

    public function delOutlet($id)
    {
        $rest = Restaurant::findOrFail($id);

        $img = $rest->picture;
        
        if($img){
            // unlink old picture
            $oldFilePath = public_path('/images/assets/outlets/'.$img);
            
            if(file_exists($oldFilePath)){
                unlink($oldFilePath);
            }
        }
        
        $rest->delete();
            
        return response()->json(['message' => 'deleted', 200]);
    }

    public function getLocsInCity($id)
    {
        $locs = Location::where('city_id', $id)->get();

        return response()->json($locs, 200);
    }

    public function updateOutlet(Request $request, $id)
    {
        // print_r($request->all());
        $this->validate($request, [
            'outlet.name' => 'required|max:100',
            'outlet.phone' => 'required|numeric',
            'outlet.address' => 'required|max:120',
            'outlet.location' => 'required',
            'outlet.opening_hr' => 'required',
            'outlet.closing_hr' => 'required'
        ]);
        // print_r($request->outlet);

        $outlet = Restaurant::findOrFail($id);
        $outlet->update([
            $outlet->name = $request->outlet['name'],
            $outlet->phone = $request->outlet['phone'],
            $outlet->address = $request->outlet['address'],
            $outlet->location_id = $request->outlet['location'],
            $outlet->opening_hr = $request->outlet['opening_hr'],
            $outlet->closing_hr = $request->outlet['closing_hr'],
        ]);

        return response()->json($outlet->load('city'), 200);
    }

    public function getOutlet($id)
    {
        $outlet = Restaurant::findOrFail($id);

        return response()->json($outlet->load(['city', 'location']), 200);
    }

    public function updateOutletLogo(Request $request, $id)
    {
        $outlet = Restaurant::findOrFail($id);

        $this->validate($request, [
            'file' => 'mimes:jpeg,jpg,bmp,png,gif,pdf',
        ]);

        $oldFile = $outlet->picture;

        // unlink old file
        if($oldFile){
            $oldFilePath = public_path('/images/assets/outlets/'.$oldFile);
            if(file_exists($oldFilePath)){
                unlink($oldFilePath);
            }
        }

        //store new file
        $file = $request->file;
        $OriginalName = $file->getClientOriginalName();
        $exp_name = explode('.', $OriginalName); 
        $ext = $file->getClientOriginalExtension();
        $pool = '0123456789abcdefghijklmnopqrstuvwxyz@&';
        $filename = substr(str_shuffle($pool), 0, 8).".".$ext;

        //save new file in serverfolder
        $file_loc = public_path('/images/assets/outlets/'.$filename);
        $upload = Image::make($file)->resize(225, 225, function($constraint){
            $constraint->aspectRatio();
        });
        $upload->sharpen(2)->save($file_loc);

        //update in db
        $outlet->update([
            $outlet->picture = $filename
        ]);
        
        return response()->json($outlet->picture, 200);
    }

    public function createCity(Request $request)
    {
        $this->validate($request, [
            'city.name' => 'required|max:20'
        ]);

        $city = new City;
        $city->name = $request->city['name'];
        $city->save();

        return response()->json($city->load(['location', 'restaurant']), 200);
    }

    public function updateCity(Request $request, $id)
    {
        $this->validate($request, [
            'city' => 'required|max:20'
        ]);

        $city = City::findOrFail($id);
        $city->update([
            $city->name = $request->city
        ]);
        
        return response()->json($city, 200);
    }

    public function deleteCity($id)
    {
       $city = City::findOrFail($id);
       $city->delete();
       return response()->json(['message'=> 'deleted']);
    }

    public function getAllLocs()
    {
        $locs = Location::all();

        return response()->json($locs->load(['restaurant', 'city']), 200);
    }

    public function createLocation(Request $request)
    {
        $this->validate($request, [
            'location.name' => 'required|max:20',
            'location.city' => 'required'
        ]);

        $location = new Location;
        $location->name = $request->location['name'];
        $location->city_id = $request->location['city'];
        $location->save();

        return response()->json($location->load(['restaurant', 'city']), 200);
    }

    public function deleteLocation($id)
    {
        $loc = Location::findOrFail($id);

        $loc->delete();

        return response()->json(['message' => 'deleted', 200]);
    }

    public function updateLocation(Request $request, $id)
    {
        $this->validate($request, [
            'location.name' => 'required|max:20',
            'location.city' => 'required'
        ]);

        $location = Location::findOrFail($id);
        $location->update([
            $location->name = $request->location['name'],
            $location->city_id = $request->location['city_id']
        ]);
        
        return response()->json($location, 200);
    }
}
