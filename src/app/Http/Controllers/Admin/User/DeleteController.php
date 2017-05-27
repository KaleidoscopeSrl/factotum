<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Content;

class DeleteController extends Controller
{
    public function delete($id)
	{
		$user = User::with('profile')->find($id);
		$users = User::where('id', '<>', $id)->with('profile')->get();
		return view('factotum::admin.user.delete')
						->with('title', Lang::get('factotum::user.delete_user_title') . ' : ' . $user->profile->first_name . ' ' . $user->profile->last_name)
						->with('users', $users);
	}

	public function deleteUser(Request $request, $id)
	{
		$this->validator($request->all())->validate();

		$reassigningUser = $request->input('reassigned_user');

		Content::where('user_id', $id)
				->update(['user_id' => $reassigningUser]);

		User::destroy($id);

		return redirect('/admin/user/list')
			->with('message', Lang::get('factotum::user.success_delete_user'));
	}

	protected function validator( array $data, $userId = false )
	{
		$rules = array(
			'reassigned_user' => 'required',
		);
		return Validator::make($data, $rules);
	}
}
