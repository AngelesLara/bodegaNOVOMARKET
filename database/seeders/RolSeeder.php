<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Vendedor']);

        Permission::create(['name' => 'dashboard'])->assignRole($role1);

        Permission::create(['name' => 'productos.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'productos.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'productos.edit'])->assignRole($role1);
        Permission::create(['name' => 'productos.delete'])->assignRole($role1);
        Permission::create(['name' => 'productos.reportes'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'categorias.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'categorias.edit'])->assignRole($role1);
        Permission::create(['name' => 'categorias.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'categorias.delete'])->assignRole($role1);

        Permission::create(['name' => 'formas-pago.index'])->assignRole($role1);
        Permission::create(['name' => 'formas-pago.create'])->assignRole($role1);
        Permission::create(['name' => 'formas-pago.edit'])->assignRole($role1);
        Permission::create(['name' => 'formas-pago.delete'])->assignRole($role1);

        Permission::create(['name' => 'proveedores.index'])->assignRole($role1);
        Permission::create(['name' => 'proveedores.create'])->assignRole($role1);
        Permission::create(['name' => 'proveedores.edit'])->assignRole($role1);
        Permission::create(['name' => 'proveedores.delete'])->assignRole($role1);
        Permission::create(['name' => 'proveedores.reportes'])->assignRole($role1);

        Permission::create(['name' => 'clientes.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'clientes.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'clientes.edit'])->assignRole($role1);
        Permission::create(['name' => 'clientes.delete'])->assignRole($role1);
        Permission::create(['name' => 'clientes.reportes'])->assignRole($role1);

        Permission::create(['name' => 'usuarios.index'])->assignRole($role1);
        Permission::create(['name' => 'usuarios.create'])->assignRole($role1);
        Permission::create(['name' => 'usuarios.edit'])->assignRole($role1);
        Permission::create(['name' => 'usuarios.delete'])->assignRole($role1);

        Permission::create(['name' => 'gastos.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'gastos.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'gastos.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'gastos.delete'])->assignRole($role1);
        Permission::create(['name' => 'gastos.reportes'])->assignRole($role1);

        Permission::create(['name' => 'compania.update'])->assignRole($role1);

        Permission::create(['name' => 'venta.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'venta.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'venta.anular'])->assignRole($role1);
        Permission::create(['name' => 'venta.reportes'])->assignRole($role1);

        Permission::create(['name' => 'creditoventa.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'creditoventa.abonos'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'creditoventa.reportes'])->assignRole($role1);

        Permission::create(['name' => 'compra.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'compra.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'compra.anular'])->assignRole($role1);
        Permission::create(['name' => 'compra.reportes'])->assignRole($role1);

        Permission::create(['name' => 'cotizacion.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cotizacion.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cotizacion.eliminar'])->assignRole($role1);
        Permission::create(['name' => 'cotizacion.reportes'])->assignRole($role1);

        Permission::create(['name' => 'cajas.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cajas.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cajas.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cajas.reportes'])->assignRole($role1);

        Permission::create(['name' => 'roles.update'])->assignRole($role1);

        Permission::create(['name' => 'movimientos.index'])->syncRoles([$role1, $role2]);
    }
}
