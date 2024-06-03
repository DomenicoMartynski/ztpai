import { Component } from '@angular/core';
import { ActivatedRoute, RouterLink, Router} from '@angular/router';
import { GameService } from '../../services/game.service';
import { UserService } from '../../services/user.service';
@Component({
  selector: 'app-category',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './category.component.html',
  styleUrls: ['../gamedetails/gamedetails.component.css', '../../home/home.component.css','./category.component.css']
})
export class CategoryComponent {
  games: any = {};
  platformId: number = 0;
  constructor(
    private gameService: GameService,
    private userService: UserService,
    private route: ActivatedRoute,
    private router: Router,
  ) {}
  goBack() {
    this.router.navigate(['/']);
  }
  ngOnInit(): void {
    this.route.params.subscribe(params => {
        this.platformId = +params['id'];
        console.log(this.platformId);
        this.loadGames();
    });
}
  loadGames(): void{
  this.gameService.getGamesByPlatformId(this.platformId).subscribe({
    next: data => {
        this.games = data;
    },
    error: error => {
        console.error('Error fetching game data:', error);
    }
  });
  }
  public isUserLoggedIn(): boolean {
    return this.userService.isUserLoggedIn();
  }

  public isUserAdmin(): boolean {
    return this.userService.isUserAdmin();
  }
  goToGamePage(gameId: number) {
    this.router.navigate(['/gamedetails', gameId]);
  }
}
