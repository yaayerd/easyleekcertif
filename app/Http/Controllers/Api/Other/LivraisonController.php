<?php

namespace App\Http\Controllers\Api\Other;

use Exception;
use App\Models\Livreur;
use App\Models\Commande;
use App\Models\Livraison;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LivraisonController extends Controller
{

    public function affecterLivraison($livreur_id, $commande_id)
    {
        try {

            if (auth()->user() && in_array(auth()->user()->role_id, [1, 2])) {

            $livreur = Livreur::find($livreur_id);
            $commande = Commande::find($commande_id);

            if ($livreur->statutLivreur !== 'disponible') {
                return response()->json([
                    'status' => false,
                    'statut_code' => 400,
                    'error' => "Le livreur n'est pas disponible pour effectuer cette livraison.",
                ], 400);
            }

            $livraison = new Livraison();

            $livraison->livreur_id = $livreur->id;
            $livraison->commande_id = $commande->id;
            $commande->etatLivraison = 'en_cours';


            $livraison->save();

            $livreur->statutLivreur = 'occupe';
            $livreur->save();

            return response()->json([
                'status' => true,
                'statut_code' => 200,
                'message' => "Livraison enregistrée avec succès.",
                'data' => $livraison,
        //         'nom_Plat' = $commande->plat->libelle,
        //     'livreur name'= $livreur->user->name,
        //    'numeroCommande '= $commande->numeroCommande
            ], 200); 
        } else {
            return response()->json([
                'status' => true,
                'statut_code' => 403,
                'message' => "Vous ne pouvez affecter une livraison à un livreur.",
            ], 403); 
        }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'error' => "Une erreur est survenue lors de l'enregistrement de la livraison.",
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
