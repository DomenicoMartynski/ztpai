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
export class HomeComponent  implements OnInit{
  games: any;
  worst: any;
  best: any;
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
    this.loadFeaturedGames();
    this.loadWorstGames();
    this.loadBestGames();
  }

  goToGamePage(gameId: number) {
    this.router.navigate(['/gamedetails', gameId]);
  }


  private loadFeaturedGames() {
    this.gameService.getFeaturedGames().subscribe({
        next: data => {
            this.games = data;
        },
        error: error => {
            console.error('Error fetching games:', error);
        }
    });
  }
  private loadWorstGames() {
    this.gameService.getWorstGames().subscribe({
        next: data => {
            this.worst = data;
        },
        error: error => {
            console.error('Error fetching worst games:', error);
        }
    });
  }
    private loadBestGames() {
      this.gameService.getBestGames().subscribe({
          next: data => {
              this.best = data;
          },
          error: error => {
              console.error('Error fetching best games:', error);
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
