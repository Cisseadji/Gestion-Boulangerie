import { Produit } from "./produit";

export class Promotion {
  id!: number;
  titre!: string;
  description!: string;
  pourcentage_remise!: number;
  date_debut!: string;
  date_fin!: string;
  actif?: boolean;
  produits!: Produit[];
}

