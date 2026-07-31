<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequisitoIsoSeeder extends Seeder
{
    public function run(): void
    {
        $requisitos = [
            [
                'tipo' => 'Clausula',
                'codigo' => '4.1',
                'categoria' => 'Contexto de la Organización',
                'titulo' => 'Comprensión de la organización y de su contexto',
                'descripcion' => 'Determinar las cuestiones externas e internas que son relevantes para su propósito y que afectan a su capacidad para lograr los resultados previstos de su SGSI.',
                'orientacion_implementacion' => 'Identificar factores externos (legales, tecnológicos, competitivos) e internos (valores, cultura, conocimiento) mediante un análisis FODA o PESTEL.',
            ],
            [
                'tipo' => 'Clausula',
                'codigo' => '5.1',
                'categoria' => 'Liderazgo',
                'titulo' => 'Liderazgo y compromiso',
                'descripcion' => 'La alta dirección debe demostrar liderazgo y compromiso con respecto al SGSI.',
                'orientacion_implementacion' => 'Asegurar la integración de los requisitos del SGSI en los procesos de negocio y asignar los recursos necesarios para su funcionamiento.',
            ],
            [
                'tipo' => 'Anexo A',
                'codigo' => 'A.5.1',
                'categoria' => 'Organizacional',
                'titulo' => 'Políticas para la seguridad de la información',
                'descripcion' => 'Las políticas de seguridad de la información y las políticas específicas del tema deben ser definidas, aprobadas por la dirección, publicadas, comunicadas y revisadas periódicamente.',
                'orientacion_implementacion' => 'Crear una política marco aprobada por la Alta Dirección y difundirla a todos los empleados mediante sesiones de inducción y el portal interno.',
            ],
            [
                'tipo' => 'Anexo A',
                'codigo' => 'A.5.7',
                'categoria' => 'Organizacional',
                'titulo' => 'Inteligencia sobre amenazas',
                'descripcion' => 'La información sobre amenazas a la seguridad de la información debe ser recopilada y analizada para producir inteligencia sobre amenazas.',
                'orientacion_implementacion' => 'Suscribirse a boletines de seguridad (como CERT nacionales, proveedores de antivirus) y analizar vulnerabilidades aplicables a la infraestructura del negocio.',
            ],
            [
                'tipo' => 'Anexo A',
                'codigo' => 'A.6.3',
                'categoria' => 'Personas',
                'titulo' => 'Concienciación, educación y capacitación en seguridad de la información',
                'descripcion' => 'El personal de la organización y las partes interesadas relevantes deben recibir la concientización, educación y capacitación adecuadas.',
                'orientacion_implementacion' => 'Ejecutar un programa anual de capacitaciones que incluya simulaciones de phishing, buenas prácticas de contraseñas y reporte de incidentes.',
            ],
            [
                'tipo' => 'Anexo A',
                'codigo' => 'A.7.1',
                'categoria' => 'Físico',
                'titulo' => 'Perímetros de seguridad física',
                'descripcion' => 'Los perímetros de seguridad se deben definir y utilizar para proteger las áreas que contienen información y otros activos asociados.',
                'orientacion_implementacion' => 'Instalar controles de acceso físico (tarjetas magnéticas, biometría) en centros de datos, salas de servidores y áreas de archivo confidencial.',
            ],
            [
                'tipo' => 'Anexo A',
                'codigo' => 'A.8.1',
                'categoria' => 'Tecnológico',
                'titulo' => 'Dispositivos de usuario final',
                'descripcion' => 'La información almacenada, procesada o accesible a través de los dispositivos del usuario final debe ser protegida.',
                'orientacion_implementacion' => 'Implementar cifrado de disco (ej. BitLocker), bloqueo automático de pantalla tras inactividad y antivirus centralizado en todas las computadoras.',
            ],
            [
                'tipo' => 'Anexo A',
                'codigo' => 'A.8.9',
                'categoria' => 'Tecnológico',
                'titulo' => 'Gestión de la configuración',
                'descripcion' => 'Las configuraciones, incluidas las configuraciones de seguridad, de hardware, software, servicios y redes, deben establecerse, documentarse, implementarse y monitorearse.',
                'orientacion_implementacion' => 'Documentar plantillas de configuración segura (hardening) para servidores y equipos de red, deshabilitando servicios no utilizados.',
            ],
        ];

        foreach ($requisitos as $req) {
            DB::table('requisitos_iso')->insert(
                array_merge($req, ['created_at' => now()])
            );
        }
    }
}