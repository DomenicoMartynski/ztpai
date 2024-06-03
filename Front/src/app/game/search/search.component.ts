import { Component } from '@angular/core';
import { FormControl, FormGroup } from '@angular/forms';
import { RouterLink, Router } from '@angular/router';
import { GameService } from '../../services/game.service';
import { UserService } from '../../services/user.service';
@Component({
  selector: 'app-search',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './search.component.html',
  styleUrls: ['../gamedetails/gamedetails.component.css', '../../home/home.component.css','../category/category.component.css']
})
export class SearchComponent {
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
    this.loadGames();
  }

  goToGamePage(gameId: number) {
    this.router.navigate(['/gamedetails', gameId]);
  }
  
  private loadGames() {
    this.gameService.getGames().subscribe({
        next: data => {
            this.games = data;
        },
        error: error => {
            console.error('Error fetching games:', error);
        }
    });
  }

}
