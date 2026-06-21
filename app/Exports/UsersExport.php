<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return User::with('roles')->get();
    }
    
    /**
     * @param User $user
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->email_verified_at ? 'Verificado' : 'No verificado',
            $user->getRoleNames()->implode(', '), // Roles usando Spatie Permission
            $user->direcciones()->count(), // Número de direcciones
            $user->metodosPago()->count(), // Número de métodos de pago
            $user->compras()->count(), // Número de compras
            $user->carrito()->count(), // Ítems en carrito
            $user->favoritos()->count(), // Productos favoritos
            $user->created_at->format('d/m/Y H:i'),
            $user->updated_at->format('d/m/Y H:i'),
        ];
    }
    
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Email',
            'Email Verificado',
            'Roles',
            'Direcciones',
            'Métodos Pago',
            'Compras',
            'Ítems Carrito',
            'Favoritos',
            'Fecha Registro',
            'Última Actualización'
        ];
    }
}
