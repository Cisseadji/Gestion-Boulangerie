export class Produit {
 id!: number;
  nom!: string;
  description!: string;
  prix!: number;
  stock!: number;
  image_url!: string;
  allergenes!: string[];
  id_categorie!: { id: number; nom: string };
   isPromo?: boolean;
  promoPrix?: number;
}
