import { Component } from '@angular/core';
import { ActivatedRoute, RouterLink, Router } from '@angular/router';
import { GameService } from '../../services/game.service';
import { UserService } from '../../services/user.service';
@Component({
  selector: 'app-gamedetails',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './gamedetails.component.html',
  styleUrl: './gamedetails.component.css'
})
export class GamedetailsComponent {
  game: any = {};
  gameId: number = 0;
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
        this.gameId = +params['id'];
        this.loadGame();
    });
}
loadGame(): void{
  this.gameService.getGame(this.gameId).subscribe({
    next: data => {
        this.game= data;
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
}
