import { Component } from '@angular/core';
import { ActivatedRoute, RouterLink, Router } from '@angular/router';
import { GameService } from '../../services/game.service';
import { UserService } from '../../services/user.service';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { ReviewService } from '../../services/review.service';
@Component({
  selector: 'app-gamedetails',
  standalone: true,
  imports: [RouterLink, ReactiveFormsModule, CommonModule],
  templateUrl: './gamedetails.component.html',
  styleUrl: './gamedetails.component.css'
})
export class GamedetailsComponent {
  game: any = {};
  gameId: number = 0;
  reviewform: FormGroup;
  message: string = '';
  constructor(
    private fb: FormBuilder,
    private gameService: GameService,
    private userService: UserService,
    private reviewService: ReviewService,
    private route: ActivatedRoute,
    private router: Router,
  ) {  this.reviewform = this.fb.group({});}
  goBack() {
    this.router.navigate(['/']);
  }
  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.gameId = +params['id'];
      this.loadGame();
  });
    this. reviewform = this.fb.group({
      rating_given: [''],
      game_id: this.gameId,
      review_comment: [''],
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
  submitForm(event: Event){
    event.preventDefault();

    const formData = {
      rating_given: this.reviewform.value.rating_given,
      review_comment: this.reviewform.value.review_comment,
      game_id: this.reviewform.value.game_id,
  }

    this.reviewService.reviewGame(formData).subscribe({
      next: response => {
          console.log('Added the review successfully', response);
          this.message = "Added the review successfuly";
          window.location.reload();
      },
      error: error => {
          console.error('Error adding the review', error)
          this.message = "Something went wrong. Try again";
          window.location.reload();
      }
    });
  }
}
