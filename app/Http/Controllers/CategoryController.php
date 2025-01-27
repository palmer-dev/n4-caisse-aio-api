<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
	use AuthorizesRequests;

	public function index()
	{
		$this->authorize( 'viewAny', Category::class );

		return CategoryResource::collection( Category::all() );
	}

	public function store(Request $request)
	{
		$this->authorize( 'create', Category::class );

		$data = $request->validate( [
			'name'        => ['required'],
			'slug'        => ['required'],
			'description' => ['nullable'],
			'image'       => ['nullable'],
			'parent_id'   => ['nullable', 'exists:categories'],
		] );

		return new CategoryResource( Category::create( $data ) );
	}

	public function show(Category $category)
	{
		$this->authorize( 'view', $category );

		return new CategoryResource( $category );
	}

	public function update(Request $request, Category $category)
	{
		$this->authorize( 'update', $category );

		$data = $request->validate( [
			'name'        => ['required'],
			'slug'        => ['required'],
			'description' => ['nullable'],
			'image'       => ['nullable'],
			'parent_id'   => ['nullable', 'exists:categories'],
		] );

		$category->update( $data );

		return new CategoryResource( $category );
	}

	public function destroy(Category $category)
	{
		$this->authorize( 'delete', $category );

		$category->delete();

		return response()->json();
	}
}
