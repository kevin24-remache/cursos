<?php
class RolesOptions
{
    const AdminPrincipal = 1;
    const AdministradorDePagos = 2;
    const AdministradorDeEventos = 3;
    const UsuarioPublico = 4;
}

class ModulosAdmin
{
    const CATEGORIES = 'CATEGORIES';
    const CATEGORY_LIST = 'CATEGORY_LIST';
    const CATEGORY_ADD = 'CATEGORY_ADD';
    const EVENTS = 'EVENTS';
    const EVENTS_LIST = 'EVENTS_LIST';
    const EVENTS_ADD = 'EVENTS_ADD';
}

class ModulosAdminPagos
{
    const INSCRIPCIONES = 'INSCRIPCIONES';
    const CATEGORY_LIST = 'CATEGORY_LIST';
    const CATEGORY_ADD = 'CATEGORY_ADD';
    const EVENTS = 'EVENTS';
    const EVENTS_LIST = 'EVENTS_LIST';
    const EVENTS_ADD = 'EVENTS_ADD';
}

class PaymentStatus
{
    const Pendiente = 1;
    const Completado = 2;
    const Fallido = 3;
    const EnProceso = 4;
    const Cancelado = 5;
}
if (!function_exists('getPaymentStatusText')) {
    function getPaymentStatusText($status)
    {
        switch ($status) {
            case PaymentStatus::Pendiente:
                return 'Pendiente';
            case PaymentStatus::Completado:
                return 'Completado';
            case PaymentStatus::Fallido:
                return 'Fallido';
            case PaymentStatus::EnProceso:
                return 'EnProceso';
            case PaymentStatus::Cancelado:
                return 'Cancelado';
            default:
                return 'Desconocido';
        }
    }
}
if (!function_exists('mapEstadoToValue')) {
    function mapEstadoToValue($estadoText)
    {
        switch (strtolower($estadoText)) {
            case 'pendiente':
                return PaymentStatus::Pendiente;
            case 'completado':
                return PaymentStatus::Completado;
            case 'fallido':
                return PaymentStatus::Fallido;
            case 'enproceso':
                return PaymentStatus::EnProceso;
            case 'cancelado':
                return PaymentStatus::Cancelado;
            default:
                return null; // Estado inválido
        }
    }
}
