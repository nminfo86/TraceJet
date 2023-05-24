<?php
// App/Scopes/BySectionScope.php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BySectionScope implements Scope
{
    /**
     * The section ID to filter by.
     *
     * @var int
     */
    protected $postSectionId;

    /**
     * Create a new scope instance.
     *
     * @param int $postSectionId The section ID to filter by.
     *
     * @return void
     */
    public function __construct($post_section_id)
    {
        $this->postSectionId = $post_section_id;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model   $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // List of roles that can access all sections
        $rolesList = ["owner", "super_admin"];

        // Get the authenticated user
        $user = Auth::user();

        // Get the user's role
        $role = $user->roles_name[0];

        // Check if the user's role is in the roles list
        // If so, the user can access all sections
        if (in_array($role, $rolesList)) {
            return;
        }

        // Filter the query to include only products in the user's section
        $builder->whereHas('section', function ($query) {
            $query->where('section_id', $this->postSectionId);
        });




         // Check if the model is the Section model
        //  if ($model instanceof Section) {
        //     return $builder->where("id", $this->postSectionId);
        // }
    }
}
