<?php

namespace App\Http\Middleware;

use App\Services\Auditor;
use Closure;

class Auditoria
{

    /**
     * @var Auditor
     */
    private $auditor;

    public function __construct(Auditor $auditor)
    {
        $this->auditor = $auditor;
    }

    /**
     * Trata o request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     * @throws UnauthorizedAccessException
     */
    public function handle($request, Closure $next)
    {
        if (!app()->runningInConsole()) {
            if (auth()->check()) {
                //$auditoriaRegistro = $this->auditor->auditar();
                //session(['id_auditoria' => $auditoriaRegistro->id]);
                session()->forget('id_auditoria');
            }
        }

        return $next($request);
    }
}
