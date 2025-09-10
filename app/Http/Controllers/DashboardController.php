<?php
namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getStats()
    {
        return [
            'totalCommandes'   => Commande::count(),
            'commandesEnCours' => Commande::whereIn('statut', ['EN_PREPARATION','PRETE','EN_LIVRAISON'])->count(),
            'chiffreAffaires'  => Commande::whereMonth('created_at', Carbon::now()->month)->sum('total'),
            'nouveauxClients'  => User::where('role', 'CLIENT')
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count(),
        ];
    }

    public function getCommandesRecentes()
    {
        return Commande::with('produits')->latest()->take(5)->get();
    }

    public function getProduitsPopulaires()
    {
        return Produit::select('produits.*', DB::raw('SUM(commandes_produits.quantite) as ventes'))
            ->join('commandes_produits', 'produits.id', '=', 'commandes_produits.id_produit')
            ->groupBy('produits.id')
            ->orderByDesc('ventes')
            ->take(5)
            ->get()
            ->map(function ($produit) {
                $produit->evolution = '+5%'; // exemple
                return $produit;
            });
    }

    public function getPromotions()
    {
        return Promotion::where('date_fin', '>=', Carbon::today())->get();
    }

    public function getVentes()
    {
        return Commande::select(DB::raw('DATE(created_at) as date, SUM(total) as ventes'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn($row) => [
                'periode' => $row->date,
                'ventes' => $row->ventes
            ]);
    }
}
