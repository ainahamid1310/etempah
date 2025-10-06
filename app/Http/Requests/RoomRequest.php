<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'nama_bilik' => 'required',
            'nama_bilik_panjang' => 'required',
            'nama_petugas' => 'required',
            'no_tel_petugas' => 'required',
            'department' => 'required',
            'aras' => 'required|integer',
            'kapasiti' => 'required|integer',
            'is_equipment' => 'required',
            'is_projector' => 'required',
            'is_upload' => 'required',
            'status' => 'required',
            'is_auto' => 'required',
            'email_status' => 'required_if:is_auto,Y',
            'is_pantry' => 'required_if:is_auto,Y',
            'departments' => 'array|required_if:is_auto,Y',
            'supervisors' => 'array|required_if:is_auto,Y',
        ];
    }

    public function messages()
    {
        return [
            'nama_bilik.required' => 'Medan Nama Bilik diperlukan',
            'nama_bilik_panjang.required' => 'Medan Nama Bilik Panjang diperlukan',
            'nama_petugas.required' => 'Medan Nama Petugas diperlukan',
            'no_tel_petugas.required' => 'Medan No. Telefon Petugas diperlukan',
            'department.required' => 'Medan Bahagian diperlukan',
            'aras.required' => 'Medan Aras diperlukan',
            'aras.integer' => 'Medan Aras mestilah integer',
            'kapasiti.required' => 'Medan Kapasiti diperlukan',
            'kapasiti.integer' => 'Medan Kapasiti mestilah integer',
            'is_equipment.required' => 'Medan Peralatan VC diperlukan',
            'is_projector.required' => 'Medan Projecktor diperlukan',
            'is_upload.required' => 'Medan Keperluan Lampiran diperlukan',
            'status.required' => 'Medan Status diperlukan',
            'is_auto.required' => 'Medan Permohonan Tempahan Melalui eBilik diperlukan',
            'is_pantry.required_if' => 'Medan Permohonan Sajian diperlukan',
            'email_status.required_if' => 'Medan Penghantaran E-mel diperlukan',
            'departments.required_if' => 'Medan Bahagian Pemohon Bilik diperlukan',
            'supervisors.required_if' => 'Medan Nama Pelulus Bilik diperlukan',
        ];
    }
}
