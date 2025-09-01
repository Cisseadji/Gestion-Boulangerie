import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { CommandeService } from '../../services/commande.service';
import { Commande } from '../../models/commande';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-add-commande',
  templateUrl: './add-commande.component.html',
  styleUrls: ['./add-commande.component.css']
})
export class AddCommandeComponent implements OnInit {
  id!: number;
  submitted = false;
  userId!: number; // ✅ ID du client connecté

  commandeForm: FormGroup = new FormGroup({
    total: new FormControl(0, [Validators.required, Validators.min(1)]),
    statut: new FormControl('EN_PREPARATION', [Validators.required]),
    mode_paiement: new FormControl('A_LA_LIVRAISON', [Validators.required]),
    date_commande: new FormControl(new Date().toISOString(), [Validators.required])
  });

  constructor(
    private commandeService: CommandeService,
    private authService: AuthService,   // ✅ pour récupérer le user
    private router: Router,
    private route: ActivatedRoute
  ) {}

  ngOnInit(): void {
    // ✅ récupérer l'id du client connecté
    this.userId = this.authService.getUserId();

    if (this.route.snapshot.paramMap.get('id')) {
      this.id = this.route.snapshot.params['id'];
      this.getById(this.id);
    }
  }

  getById(id: number) {
    this.commandeService.getById(id).subscribe({
      next: (data: Commande) => {
        this.commandeForm.patchValue(data);
      },
      error: (err) => console.error(err)
    });
  }

  get f() {
    return this.commandeForm.controls;
  }

  onSubmit() {
    this.submitted = true;

    if (this.commandeForm.valid) {
      // ✅ ajouter automatiquement le client connecté
      const commande: Commande = {
        ...this.commandeForm.value,
        id_client: this.userId
      };

      if (this.id) {
        // Update
        this.commandeService.updateCommande(this.id, commande).subscribe({
          next: () => this.router.navigateByUrl('/commande'),
          error: (err) => console.error(err)
        });
      } else {
        // Add
        this.commandeService.addCommande(commande).subscribe({
          next: () => this.router.navigateByUrl('/commande'),
          error: (err) => console.error(err)
        });
      }
    }
  }
}
