<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    
    public function setup() 
	{
	    $owner = new Role();
	    $owner->name         = 'owner';
	    $owner->display_name = 'Project Owner'; // optional
	    $owner->description  = 'User is the owner of a given project'; // optional
	    $owner->save();

	    $admin = new Role();
	    $admin->name         = 'admin';
	    $admin->display_name = 'User Administrator'; // optional
	    $admin->description  = 'User is allowed to manage and edit other users'; // optional
	    $admin->save();

	    $manager = new Role();
	    $manager->name         = 'manager';
	    $manager->display_name = 'Company Manager'; // optional
	    $manager->description  = 'User is a manager of a Department'; // optional
	    $manager->save();
	}
	
	public function permissions()
	{
		return $this->belongsToMany(Permission::class);
	}
}
