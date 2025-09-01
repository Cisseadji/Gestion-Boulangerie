import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { Produit } from '../models/produit';


export interface CartItem {
  produit: Produit;
  quantity: number;
}

@Injectable({ providedIn: 'root' })
export class CartService {
  private readonly storageKey = 'client_cart_v1';
  private _items: CartItem[] = this.restore();
  private _cart$ = new BehaviorSubject<CartItem[]>(this._items);
  cart$ = this._cart$.asObservable();

  constructor() {}

  /** 🔹 Restaurer depuis localStorage */
  private restore(): CartItem[] {
    try {
      const raw = localStorage.getItem(this.storageKey);
      return raw ? JSON.parse(raw) : [];
    } catch {
      return [];
    }
  }

  /** 🔹 Sauvegarder dans localStorage */
  private persist() {
    localStorage.setItem(this.storageKey, JSON.stringify(this._items));
    this._cart$.next([...this._items]);
  }

  /** 🔹 Ajouter un produit au panier */
  add(produit: Produit, quantity = 1) {
    const idx = this._items.findIndex(i => i.produit.id === produit.id);
    if (idx >= 0) {
      this._items[idx] = {
        ...this._items[idx],
        quantity: this._items[idx].quantity + quantity,
      };
    } else {
      this._items.push({ produit, quantity });
    }
    this.persist();
  }

  /** 🔹 Modifier la quantité */
  update(productId: number, quantity: number) {
    if (quantity <= 0) return this.remove(productId);
    const idx = this._items.findIndex(i => i.produit.id === productId);
    if (idx >= 0) {
      this._items[idx] = { ...this._items[idx], quantity };
      this.persist();
    }
  }

  /** 🔹 Supprimer un produit */
  remove(productId: number) {
    this._items = this._items.filter(i => i.produit.id !== productId);
    this.persist();
  }

  /** 🔹 Vider le panier */
  clear() {
    this._items = [];
    this.persist();
  }

  /** 🔹 Récupérer les items */
  items(): CartItem[] {
    return [...this._items];
  }

  /** 🔹 Calculer le total */
  total(): number {
    return this._items.reduce(
      (sum, i) => sum + i.produit.prix * i.quantity,
      0
    );
  }

  /** 🔹 Nombre total d’articles */
  count(): number {
    return this._items.reduce((sum, i) => sum + i.quantity, 0);
  }
}
