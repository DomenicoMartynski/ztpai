import { Component, ViewChild, OnInit  } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { debounceTime } from 'rxjs/operators';

import { GameService } from '../services/game.service';
import { UserService } from '../services/user.service';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [RouterLink, ReactiveFormsModule],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent {
  games: any;
  searchControl = new FormControl('');
  searchForm = new FormGroup({
      searchControl: this.searchControl
  });

  constructor(
      private gameService: GameService,
      private userService: UserService,
      private router: Router,
  ) {}
  ngOnInit() {
    this.loadAllGames();
  }

  private loadAllGames() {
    this.gameService.getGames().subscribe({
        next: data => {
            this.games = data;
        },
        error: error => {
            console.error('Error fetching games:', error);
        }
    });
  }
  
  public isUserLoggedIn(): boolean {
    return this.userService.isUserLoggedIn();
  }

  public isUserAdmin(): boolean {
    return this.userService.isUserAdmin();
  }
}
