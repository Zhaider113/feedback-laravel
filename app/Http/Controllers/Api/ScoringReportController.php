<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScoringReport;
use Validator;

class ScoringReportController extends Controller
{

    public function addCow(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'customer_id' => 'required',
                'cow_id' => 'required',
                'gender' => 'required',
            ]);
            if($validator->fails())
            {
                return $this->error("Select Customer..!");
            }
            $cow = new ScoringReport;
            $cow->customer_id  = $request->customer_id;
            $cow->cow_id  = $request->cow_id;
            $cow->gender  = $request->gender;
            if($request->has('image_fl'))
            {
                if($request->image_fl->getClientOriginalExtension() == 'png' 
    			|| $request->image_fl->getClientOriginalExtension() == 'PNG' 
    			|| $request->image_fl->getClientOriginalExtension() == 'jpg' 
    			|| $request->image_fl->getClientOriginalExtension() == 'JPG' 
    			|| $request->image_fl->getClientOriginalExtension() == 'jpeg' 
    			|| $request->image_fl->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->image_fl->getClientOriginalExtension();
                    $request->file('image_fl')->move(public_path("/uploads/reports"), $newfilename);
                    $new_path1 = 'uploads/reports/'.$newfilename;
                    $score->image_fl = $new_path1;
                }
    			else
    			{
    			    return back()->with('error','Choose a Valid Image !');
    			}                       
            }
            if($request->has('image_fr'))
            {
                if($request->image_fr->getClientOriginalExtension() == 'png' 
    			|| $request->image_fr->getClientOriginalExtension() == 'PNG' 
    			|| $request->image_fr->getClientOriginalExtension() == 'jpg' 
    			|| $request->image_fr->getClientOriginalExtension() == 'JPG' 
    			|| $request->image_fr->getClientOriginalExtension() == 'jpeg' 
    			|| $request->image_fr->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->image_fr->getClientOriginalExtension();
                    $request->file('image_fr')->move(public_path("/uploads/reports"), $newfilename);
                    $new_path1 = 'uploads/reports/'.$newfilename;
                    $score->image_fl = $new_path1;
                }
    			else
    			{
    			    return back()->with('error','Choose a Valid Image !');
    			}                       
            }
            if($request->has('image_bl'))
            {
                if($request->image_bl->getClientOriginalExtension() == 'png' 
    			|| $request->image_bl->getClientOriginalExtension() == 'PNG' 
    			|| $request->image_bl->getClientOriginalExtension() == 'jpg' 
    			|| $request->image_bl->getClientOriginalExtension() == 'JPG' 
    			|| $request->image_bl->getClientOriginalExtension() == 'jpeg' 
    			|| $request->image_bl->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->image_bl->getClientOriginalExtension();
                    $request->file('image_bl')->move(public_path("/uploads/reports"), $newfilename);
                    $new_path1 = 'uploads/reports/'.$newfilename;
                    $score->image_bl = $new_path1;
                }
    			else
    			{
    			    return back()->with('error','Choose a Valid Image !');
    			}                       
            }
            if($request->has('image_br'))
            {
                if($request->image_br->getClientOriginalExtension() == 'png' 
    			|| $request->image_br->getClientOriginalExtension() == 'PNG' 
    			|| $request->image_br->getClientOriginalExtension() == 'jpg' 
    			|| $request->image_br->getClientOriginalExtension() == 'JPG' 
    			|| $request->image_br->getClientOriginalExtension() == 'jpeg' 
    			|| $request->image_br->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->image_br->getClientOriginalExtension();
                    $request->file('image_br')->move(public_path("/uploads/reports"), $newfilename);
                    $new_path1 = 'uploads/reports/'.$newfilename;
                    $score->image_br = $new_path1;
                }
    			else
    			{
    			    return back()->with('error','Choose a Valid Image !');
    			}                       
            }
            $cow->save();
            if ($cow) 
            {
                return $this->success(['Cow Added successfully....!']);
            }
            else
            {
                return $this->error(['Adding failed !']);
            }

        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    public function viewCow(string $id){
        try {
            $scoring = ScoringReport::where('cow_id', $id)->get();
            return $this->success([$scoring->count() > 0 ? 'Cows Found' : 'No Cows Found', $scoring]);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    public function getCustomerCows(string $id){
        try {
            $scoring = ScoringReport::select(['id', 'customer_id', 'cow_id', 'gender', 'image_fl', 'image_fr', 'image_bl', 'image_br'])->where('customer_id', $id)->get();
            return $this->success([$scoring->count() > 0 ? 'Cows Found' : 'No Cows Found', $scoring]);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'cow_id' => 'required',
            ]);
            if($validator->fails())
            {
                return $this->error("Select Cow..!");
            }
            $score = ScoringReport::where('cow_id', $request->cow_id)->first();
            if(empty($score))
            {
                return $this->error('Cow not found');
            }
            $score->sole_bruising_fl    = $request->sole_bruising_fl;
            $score->sole_bruising_fr    = $request->sole_bruising_fr;
            $score->sole_bruising_bl    = $request->sole_bruising_bl;
            $score->sole_bruising_br    = $request->sole_bruising_br;
            $score->sole_ulcer_fl       = $request->sole_ulcer_fl;
            $score->sole_ulcer_fr       = $request->sole_ulcer_fr;
            $score->sole_ulcer_bl       = $request->sole_ulcer_bl;
            $score->sole_ulcer_br       = $request->sole_ulcer_br;
            $score->wall_ulcer_fl       = $request->wall_ulcer_fl;
            $score->wall_ulcer_fr       = $request->wall_ulcer_fr;
            $score->wall_ulcer_bl       = $request->wall_ulcer_bl;
            $score->wall_ulcer_br       = $request->wall_ulcer_br;
            $score->toe_ulcer_fl        = $request->toe_ulcer_fl;
            $score->toe_ulcer_fr        = $request->toe_ulcer_fr;
            $score->toe_ulcer_bl        = $request->toe_ulcer_bl;
            $score->toe_ulcer_br        = $request->toe_ulcer_br;
            $score->heel_ulcer_fl       = $request->heel_ulcer_fl;
            $score->heel_ulcer_fr       = $request->heel_ulcer_fr;
            $score->heel_ulcer_bl       = $request->heel_ulcer_bl;
            $score->heel_ulcer_br       = $request->heel_ulcer_br;
            $score->white_linee_fl      = $request->white_linee_fl;
            $score->white_linee_fr      = $request->white_linee_fr;
            $score->white_linee_bl      = $request->white_linee_bl;
            $score->white_linee_br      = $request->white_linee_br;
            $score->digital_fl          = $request->digital_fl;
            $score->digital_fr          = $request->digital_fr;
            $score->digital_bl          = $request->digital_bl;
            $score->digital_br          = $request->digital_br;
            $score->slurry_fl           = $request->slurry_fl;
            $score->slurry_fr           = $request->slurry_fr;
            $score->slurry_bl           = $request->slurry_bl;
            $score->slurry_br           = $request->slurry_br;
            $score->foot_fl             = $request->foot_fl;
            $score->foot_fr             = $request->foot_fr;
            $score->foot_bl             = $request->foot_bl;
            $score->foot_br             = $request->foot_br;
            $score->growth_fl           = $request->growth_fl;
            $score->growth_fr           = $request->growth_fr;
            $score->growth_bl           = $request->growth_bl;
            $score->growth_br           = $request->growth_br;
            $score->joint_fl            = $request->joint_fl;
            $score->joint_fr            = $request->joint_fr;
            $score->joint_bl            = $request->joint_bl;
            $score->joint_br            = $request->joint_br;
            $score->trial_fl            = $request->trial_fl;
            $score->trial_fr            = $request->trial_fr;
            $score->trial_bl            = $request->trial_bl;
            $score->trial_br            = $request->trial_br;
            $score->blocked_fl          = $request->blocked_fl;
            $score->blocked_fr          = $request->blocked_fr;
            $score->blocked_bl          = $request->blocked_bl;
            $score->blocked_br          = $request->blocked_br;
            $score->bandaged_fl         = $request->bandaged_fl;
            $score->bandaged_fr         = $request->bandaged_fr;
            $score->bandaged_bl         = $request->bandaged_bl;
            $score->bandaged_br         = $request->bandaged_br;
            $score->block_removed_fl    = $request->block_removed_fl;
            $score->block_removed_fr    = $request->block_removed_fr;
            $score->block_removed_bl    = $request->block_removed_bl;
            $score->block_removed_br    = $request->block_removed_br;
            $score->block_left_fl       = $request->block_left_fl;
            $score->block_left_fr       = $request->block_left_fr;
            $score->block_left_bl       = $request->block_left_bl;
            $score->block_left_br       = $request->block_left_br;
            $score->limb_fl             = $request->limb_fl;
            $score->limb_fr             = $request->limb_fr;
            $score->limb_bl             = $request->limb_bl;
            $score->limb_br             = $request->limb_br;
            $score->recommendation      = $request->recommendation; 
            $score->recheck             = $request->recheck; 
            $score->damage              = $request->damage; 
            $score->comment             = $request->comment; 
            $score->limb                = $request->limb; 
            if($request->has('image_fl'))
            {
                if($request->image_fl->getClientOriginalExtension() == 'png' 
    			|| $request->image_fl->getClientOriginalExtension() == 'PNG' 
    			|| $request->image_fl->getClientOriginalExtension() == 'jpg' 
    			|| $request->image_fl->getClientOriginalExtension() == 'JPG' 
    			|| $request->image_fl->getClientOriginalExtension() == 'jpeg' 
    			|| $request->image_fl->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->image_fl->getClientOriginalExtension();
                    $request->file('image_fl')->move(public_path("/uploads/reports"), $newfilename);
                    $new_path1 = 'uploads/reports/'.$newfilename;
                    $score->image_fl = $new_path1;
                }
    			else
    			{
    			    return back()->with('error','Choose a Valid Image !');
    			}                       
            }
            if($request->has('image_fr'))
            {
                if($request->image_fr->getClientOriginalExtension() == 'png' 
    			|| $request->image_fr->getClientOriginalExtension() == 'PNG' 
    			|| $request->image_fr->getClientOriginalExtension() == 'jpg' 
    			|| $request->image_fr->getClientOriginalExtension() == 'JPG' 
    			|| $request->image_fr->getClientOriginalExtension() == 'jpeg' 
    			|| $request->image_fr->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->image_fr->getClientOriginalExtension();
                    $request->file('image_fr')->move(public_path("/uploads/reports"), $newfilename);
                    $new_path1 = 'uploads/reports/'.$newfilename;
                    $score->image_fl = $new_path1;
                }
    			else
    			{
    			    return back()->with('error','Choose a Valid Image !');
    			}                       
            }
            if($request->has('image_bl'))
            {
                if($request->image_bl->getClientOriginalExtension() == 'png' 
    			|| $request->image_bl->getClientOriginalExtension() == 'PNG' 
    			|| $request->image_bl->getClientOriginalExtension() == 'jpg' 
    			|| $request->image_bl->getClientOriginalExtension() == 'JPG' 
    			|| $request->image_bl->getClientOriginalExtension() == 'jpeg' 
    			|| $request->image_bl->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->image_bl->getClientOriginalExtension();
                    $request->file('image_bl')->move(public_path("/uploads/reports"), $newfilename);
                    $new_path1 = 'uploads/reports/'.$newfilename;
                    $score->image_bl = $new_path1;
                }
    			else
    			{
    			    return back()->with('error','Choose a Valid Image !');
    			}                       
            }
            if($request->has('image_br'))
            {
                if($request->image_br->getClientOriginalExtension() == 'png' 
    			|| $request->image_br->getClientOriginalExtension() == 'PNG' 
    			|| $request->image_br->getClientOriginalExtension() == 'jpg' 
    			|| $request->image_br->getClientOriginalExtension() == 'JPG' 
    			|| $request->image_br->getClientOriginalExtension() == 'jpeg' 
    			|| $request->image_br->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->image_br->getClientOriginalExtension();
                    $request->file('image_br')->move(public_path("/uploads/reports"), $newfilename);
                    $new_path1 = 'uploads/reports/'.$newfilename;
                    $score->image_br = $new_path1;
                }
    			else
    			{
    			    return back()->with('error','Choose a Valid Image !');
    			}                       
            }
            $score->save();
            if ($score) 
            {
                return $this->success(['Score Report uploaded successfully....!']);
            }
            else
            {
                return $this->error(['uploading failed !']);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(),[
                'cow_id' => 'required',
            ]);
            if($validator->fails())
            {
                return $this->error("Select Cow..!");
            }
            $score = ScoringReport::where('id', $id)->first();
            if(empty($score))
            {
                return $this->error('Cow not found');
            }
            $score->sole_bruising_fl    = $request->sole_bruising_fl;
            $score->sole_bruising_fr    = $request->sole_bruising_fr;
            $score->sole_bruising_bl    = $request->sole_bruising_bl;
            $score->sole_bruising_br    = $request->sole_bruising_br;
            $score->sole_ulcer_fl       = $request->sole_ulcer_fl;
            $score->sole_ulcer_fr       = $request->sole_ulcer_fr;
            $score->sole_ulcer_bl       = $request->sole_ulcer_bl;
            $score->sole_ulcer_br       = $request->sole_ulcer_br;
            $score->wall_ulcer_fl       = $request->wall_ulcer_fl;
            $score->wall_ulcer_fr       = $request->wall_ulcer_fr;
            $score->wall_ulcer_bl       = $request->wall_ulcer_bl;
            $score->wall_ulcer_br       = $request->wall_ulcer_br;
            $score->toe_ulcer_fl        = $request->toe_ulcer_fl;
            $score->toe_ulcer_fr        = $request->toe_ulcer_fr;
            $score->toe_ulcer_bl        = $request->toe_ulcer_bl;
            $score->toe_ulcer_br        = $request->toe_ulcer_br;
            $score->heel_ulcer_fl       = $request->heel_ulcer_fl;
            $score->heel_ulcer_fr       = $request->heel_ulcer_fr;
            $score->heel_ulcer_bl       = $request->heel_ulcer_bl;
            $score->heel_ulcer_br       = $request->heel_ulcer_br;
            $score->white_linee_fl      = $request->white_linee_fl;
            $score->white_linee_fr      = $request->white_linee_fr;
            $score->white_linee_bl      = $request->white_linee_bl;
            $score->white_linee_br      = $request->white_linee_br;
            $score->digital_fl          = $request->digital_fl;
            $score->digital_fr          = $request->digital_fr;
            $score->digital_bl          = $request->digital_bl;
            $score->digital_br          = $request->digital_br;
            $score->slurry_fl           = $request->slurry_fl;
            $score->slurry_fr           = $request->slurry_fr;
            $score->slurry_bl           = $request->slurry_bl;
            $score->slurry_br           = $request->slurry_br;
            $score->foot_fl             = $request->foot_fl;
            $score->foot_fr             = $request->foot_fr;
            $score->foot_bl             = $request->foot_bl;
            $score->foot_br             = $request->foot_br;
            $score->growth_fl           = $request->growth_fl;
            $score->growth_fr           = $request->growth_fr;
            $score->growth_bl           = $request->growth_bl;
            $score->growth_br           = $request->growth_br;
            $score->joint_fl            = $request->joint_fl;
            $score->joint_fr            = $request->joint_fr;
            $score->joint_bl            = $request->joint_bl;
            $score->joint_br            = $request->joint_br;
            $score->trial_fl            = $request->trial_fl;
            $score->trial_fr            = $request->trial_fr;
            $score->trial_bl            = $request->trial_bl;
            $score->trial_br            = $request->trial_br;
            $score->blocked_fl          = $request->blocked_fl;
            $score->blocked_fr          = $request->blocked_fr;
            $score->blocked_bl          = $request->blocked_bl;
            $score->blocked_br          = $request->blocked_br;
            $score->bandaged_fl         = $request->bandaged_fl;
            $score->bandaged_fr         = $request->bandaged_fr;
            $score->bandaged_bl         = $request->bandaged_bl;
            $score->bandaged_br         = $request->bandaged_br;
            $score->block_removed_fl    = $request->block_removed_fl;
            $score->block_removed_fr    = $request->block_removed_fr;
            $score->block_removed_bl    = $request->block_removed_bl;
            $score->block_removed_br    = $request->block_removed_br;
            $score->block_left_fl       = $request->block_left_fl;
            $score->block_left_fr       = $request->block_left_fr;
            $score->block_left_bl       = $request->block_left_bl;
            $score->block_left_br       = $request->block_left_br;
            $score->limb_fl             = $request->limb_fl;
            $score->limb_fr             = $request->limb_fr;
            $score->limb_bl             = $request->limb_bl;
            $score->limb_br             = $request->limb_br;
            $score->recommendation      = $request->recommendation; 
            $score->recheck             = $request->recheck; 
            $score->damage              = $request->damage; 
            $score->comment             = $request->comment; 
            $score->limb                = $request->limb; 
            if($request->has('image_fl'))
            {
                if($request->image_fl->getClientOriginalExtension() == 'png' 
    			|| $request->image_fl->getClientOriginalExtension() == 'PNG' 
    			|| $request->image_fl->getClientOriginalExtension() == 'jpg' 
    			|| $request->image_fl->getClientOriginalExtension() == 'JPG' 
    			|| $request->image_fl->getClientOriginalExtension() == 'jpeg' 
    			|| $request->image_fl->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->image_fl->getClientOriginalExtension();
                    $request->file('image_fl')->move(public_path("/uploads/reports"), $newfilename);
                    $new_path1 = 'uploads/reports/'.$newfilename;
                    $score->image_fl = $new_path1;
                }
    			else
    			{
    			    return back()->with('error','Choose a Valid Image !');
    			}                       
            }
            if($request->has('image_fr'))
            {
                if($request->image_fr->getClientOriginalExtension() == 'png' 
    			|| $request->image_fr->getClientOriginalExtension() == 'PNG' 
    			|| $request->image_fr->getClientOriginalExtension() == 'jpg' 
    			|| $request->image_fr->getClientOriginalExtension() == 'JPG' 
    			|| $request->image_fr->getClientOriginalExtension() == 'jpeg' 
    			|| $request->image_fr->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->image_fr->getClientOriginalExtension();
                    $request->file('image_fr')->move(public_path("/uploads/reports"), $newfilename);
                    $new_path1 = 'uploads/reports/'.$newfilename;
                    $score->image_fl = $new_path1;
                }
    			else
    			{
    			    return back()->with('error','Choose a Valid Image !');
    			}                       
            }
            if($request->has('image_bl'))
            {
                if($request->image_bl->getClientOriginalExtension() == 'png' 
    			|| $request->image_bl->getClientOriginalExtension() == 'PNG' 
    			|| $request->image_bl->getClientOriginalExtension() == 'jpg' 
    			|| $request->image_bl->getClientOriginalExtension() == 'JPG' 
    			|| $request->image_bl->getClientOriginalExtension() == 'jpeg' 
    			|| $request->image_bl->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->image_bl->getClientOriginalExtension();
                    $request->file('image_bl')->move(public_path("/uploads/reports"), $newfilename);
                    $new_path1 = 'uploads/reports/'.$newfilename;
                    $score->image_bl = $new_path1;
                }
    			else
    			{
    			    return back()->with('error','Choose a Valid Image !');
    			}                       
            }
            if($request->has('image_br'))
            {
                if($request->image_br->getClientOriginalExtension() == 'png' 
    			|| $request->image_br->getClientOriginalExtension() == 'PNG' 
    			|| $request->image_br->getClientOriginalExtension() == 'jpg' 
    			|| $request->image_br->getClientOriginalExtension() == 'JPG' 
    			|| $request->image_br->getClientOriginalExtension() == 'jpeg' 
    			|| $request->image_br->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->image_br->getClientOriginalExtension();
                    $request->file('image_br')->move(public_path("/uploads/reports"), $newfilename);
                    $new_path1 = 'uploads/reports/'.$newfilename;
                    $score->image_br = $new_path1;
                }
    			else
    			{
    			    return back()->with('error','Choose a Valid Image !');
    			}                       
            }
            $score->save();
            if ($score) 
            {
                return $this->success(['Score Report updated successfully....!', $score]);
            }
            else
            {
                return $this->error(['updation failed !']);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
