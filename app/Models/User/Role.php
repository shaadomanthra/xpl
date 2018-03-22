<?php

namespace PacketPrep\Models\User;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use PacketPrep\User;

class Role extends Model
{
    use NodeTrait;

     protected $fillable = [
        'name',
        'slug',
        // add all other fields
    ];
    public $timestamps = false;

    /**
     * The roles that belong to the user.
     */
    public function users()
    {
        return $this->belongsToMany('PacketPrep\User');
    }

    public static function getUsers($role){
        $role = Role::where('slug',$role)->get()->first();
        if($role){
            return $role->users;
        }else
         return null;
    }


    public static function getParent($role){
    	$result = Role::defaultOrder()->ancestorsOf($role->id);
    	//dd($result);
    	if(count($result)>0)
    	{
    		return $result[count($result)-1];
    	}
    	else
    		return null;

    }

     public static function displayUnorderedList($roles,$options=null,$i=1){
    	$d = '';
    	foreach ($roles as $role) {
    		$hasChildren = (count($role->children) > 0);

            $d = $d.'<li class="item" id="'.$role->id.'" ><a href="'.route('role.show', $role->slug).'">'.$role->name.'</a></li>';

            if($hasChildren) {
                $d = $d.Role::displayUnorderedList($role->children,$options,$i+1);
            }
        }
        if($i==1)
        $d = '<ul class="list list-first" >'.$d.'</ul>';
    	else
    	$d = '<ul class="list" >'.$d.'</ul>';	
        return $d;
    }



	 public static function displaySelectOption($roles,$options=null,$prefix='&nbsp;',$disable=false){

	 	if($prefix=='&nbsp;')
	 	$d = '<option value="0">FIRST LEVEL ROOT (DEFAULT)</option>';	
	 	else
    	$d = '';
    	foreach ($roles as $role) {
    		$hasChildren = (count($role->children) > 0);

    		$state = null;
    		if($role->id == $options['select_id'])
    			$state = 'selected';

    		if($role->id == $options['disable_id'] || $disable){
    			$state = 'disabled';
    			$disable = true;
    		}

    		if(!$hasChildren)
			$d = $d.'<option value="'.$role->id.'" '.$state.'>'.$prefix.$role->name.'</option>';
    		else
            $d = $d.'<option value="'.$role->id.'" '.$state.'>'.$prefix.$role->name.'</option>';
			

            if($hasChildren) {
                $d = $d.Role::displaySelectOption($role->children,$options,$prefix.'&nbsp;&nbsp;&nbsp;',$disable);
            }
            if($role->id == $options['disable_id'])
            	$disable = false;
        }
        return $d;
    }



     public static function displayUserRoleUnorderedList($roles,$options=null,$i=1){
    	$d = '';
    	foreach ($roles as $role) {
    		$hasChildren = (count($role->children) > 0);

    		$state = null;
    		if(in_array($role->id, $options['select_id']))
    			$state = 'checked';

            $d = $d.'<li class="item" id="'.$role->id.'" >
            			<input type="checkbox" name="role_'.$role->id.'" value="'.$role->id.'" '.$state.'> 
            			'.$role->name.'</li>';

            if($hasChildren) {
                $d = $d.Role::displayUserRoleUnorderedList($role->children,$options,$i+1);
            }
        }
        if($i==1)
        $d = '<ul class="list list-first" >'.$d.'</ul>';
    	else
    	$d = '<ul class="list" >'.$d.'</ul>';	
        return $d;
    }

     public static function displayUserRoleSelectOption($roles,$options=null,$prefix='&nbsp;'){

	 	if($prefix=='&nbsp;')
	 	$d = '<option value="0">FIRST LEVEL ROOT (DEFAULT)</option>';	
	 	else
    	$d = '';
    	foreach ($roles as $role) {
    		$hasChildren = (count($role->children) > 0);

    		$state = null;
    		if(in_array($role->id, $options['select_id']))
    			$state = 'selected';

    		if(!$hasChildren)
			$d = $d.'<option value="'.$role->id.'" '.$state.'>'.$prefix.$role->name.'</option>';
    		else
            $d = $d.'<option value="'.$role->id.'" '.$state.'>'.$prefix.$role->name.'</option>';
			

            if($hasChildren) {
                $d = $d.Role::displayUserRoleSelectOption($role->children,$options,$prefix.'&nbsp;&nbsp;&nbsp;');
            }
        }
        return $d;
    }

}
