<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:siswa,guru,satpam'],
        ];

        return match ($this->input('role')) {
            'siswa' => array_merge($rules, [
                'nis' => ['required', 'string', 'max:50', 'unique:siswa,nis'],
                'kelas' => ['required', 'string', 'max:20'],
                'nomor_absen' => ['required', 'string', 'max:100', 'unique:siswa,nomor_absen'],
                'no_telepon' => ['required', 'string', 'max:20'],
                'alamat' => ['nullable', 'string', 'max:255'],
            ]),
            'guru' => array_merge($rules, [
                'mapel' => ['required', 'string', 'max:100'],
                'nip' => ['required', 'string', 'max:30', 'unique:guru,nip'],
                'no_telepon' => ['required', 'string', 'max:20'],
            ]),
            'satpam' => array_merge($rules, [
                'nip' => ['required', 'string', 'max:30', 'unique:satpam,nip'],
                'no_telepon' => ['required', 'string', 'max:20'],
            ]),
            default => $rules,
        };
    }

    public function messages(): array
    {
        return [
            'role.in' => 'Peran yang dipilih tidak valid.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'email.unique' => 'Email sudah terdaftar.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'nomor_absen.unique' => 'Nomor absen sudah terdaftar.',
            'nip.unique' => 'NIP sudah terdaftar.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama lengkap',
            'email' => 'email',
            'password' => 'kata sandi',
            'nis' => 'NIS',
            'kelas' => 'kelas',
            'nomor_absen' => 'nomor absen',
            'no_telepon' => 'nomor telepon',
            'alamat' => 'alamat',
            'mapel' => 'mata pelajaran',
            'nip' => 'NIP',
        ];
    }
}
