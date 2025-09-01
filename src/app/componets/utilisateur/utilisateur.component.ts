import { Component, OnInit } from '@angular/core';
import { UserService } from '../../services/user.service';
import { User } from '../../models/user';
import { Router } from '@angular/router';


@Component({
  selector: 'app-utilisateur',
  templateUrl: './utilisateur.component.html',
  styleUrl: './utilisateur.component.css'
})
export class UtilisateurComponent implements OnInit {
  users: User[] = [];

  constructor(private userService: UserService, private router: Router) {}

  ngOnInit(): void {
    this.getAll();
  }

  getAll() {
    this.userService.getAll().subscribe(
      (data: User[]) => {
        this.users = data;
      },
      (error) => console.log(error)
    );
  }

  deleteUser(id: number) {
    this.userService.deleteUser(id).subscribe(
      () => this.getAll(),
      (error) => console.log(error)
    );
  }

}
