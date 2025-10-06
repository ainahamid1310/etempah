<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama' => 'required',
            'no_kp' => 'required|digits:12|unique:users,no_kp',
            'email' => 'required|email|unique:users,email',
            'position' => 'required',
            'department' => 'required',
            'no_extension' => 'required|digits:4',
            'no_bimbit' => 'required|max:12',
            'password' => 'required|min:12|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$/',
            'rpassword' => 'required|same:password|min:12',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Medan Nama diperlukan',
            'no_kp.required' => 'Medan No. Kad Pengenalan diperlukan',
            'no_kp.digits' => 'Medan No. Kad Pengenalan mestilah 12 digit',
            'no_kp.unique' => 'No. Kad Pengenalan telah didaftarkan',
            'email.required' => 'Medan E-mel diperlukan',
            'email.email' => 'Alamat E-mel mestilah mengikut format e-mel contohnya marhad@miti.gov.my',
            'email.unique' => 'Alamat E-mel telah didaftarkan',
            'position.required' => 'Medan Jawatan diperlukan',
            'department.required' => 'Medan Bahagian diperlukan',
            'no_extension.required' => 'Medan No.Sambungan diperlukan',
            'no_extension.digits' => 'Medan No.Sambungan mestilah 4 digit',
            'no_bimbit.required' => 'Medan No.Bimbit diperlukan',
            'no_bimbit.max' => 'Medan No.Bimbit tidak lebih 12 digit',
            'password.required' => 'Medan Kata laluan diperlukan',
            'password.min' => 'Medan Kata laluan mestilah sekurang-kurangnya dua belas (12) aksara dengan gabungan nombor, simbol, huruf besar dan huruf kecil.',
            'password.regex' => 'Medan Kata laluan mestilah sekurang-kurangnya dua belas (12) aksara dengan gabungan nombor, simbol, huruf besar dan huruf kecil.',
            'rpassword.required' => 'Medan Ulang Kata laluan diperlukan',
            'rpassword.same' => 'Medan Ulang kata laluan hendaklah sama dengan kata laluan',
            'rpassword.min' => 'Medan Ulang kata laluan hendaklah sama dengan kata laluan',
            'status.required' => 'Medan Status diperlukan',
        ];
    }
}
