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

    public function affecterLivraison(Request $request, $livreur_id, $commande_id)
    {
        try {
            if (auth()->user() && in_array(auth()->user()->role_id, [1, 2])) {

                $livreur = Livreur::find($livreur_id);
                $commande = Commande::find($commande_id);

                if (!$livreur || !$commande) {
                    return response()->json([
                        'status' => false,
                        'statut_code' => 404,
                        'error' => "Livreur ou commande non trouvé(e).",
                    ], 404);
                }

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
                $livraison->prixLivraison = $request->prixLivraison;
                $commande->etatLivraison = 'affectee';

                $livraison->save();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Livraison enregistrée avec succès.",
                    'data' => [
                        'livraison' => $livraison,
                        'nom_Plat' => $commande->plat->libelle,
                        'livreur_name' => $livreur->user->name,
                        'numeroCommande' => $commande->numeroCommande,
                        'lieuLivraison' => $commande->lieuLivraison,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'statut_code' => 403,
                    'error' => "Vous n'avez pas les droits pour affecter une livraison à un livreur.",
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
