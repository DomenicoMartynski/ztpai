import { Component,  OnInit  } from '@angular/core';
import { RouterLink } from '@angular/router';
import { FormBuilder, FormGroup, FormArray, FormControl, ReactiveFormsModule } from '@angular/forms';
import { GameService } from '../../services/game.service';
import { CommonModule } from '@angular/common';
@Component({
  selector: 'app-add-game',
  standalone: true,
  imports: [RouterLink, ReactiveFormsModule, CommonModule],
  templateUrl: './add-game.component.html',
  styleUrls: ['../gamedetails/gamedetails.component.css','../../my-account/my-account.component.css','./add-game.component.css']
})
export class AddGameComponent {
  addform: FormGroup = this.fb.group({});
  platforms: any[] = [];
  genres: any[] = [];
  message: string = "";

  constructor(
    private fb: FormBuilder,
    private gameService: GameService
  ) {}

  ngOnInit() {
    this.addform = this.fb.group({
      name: [''],
      date: [''],
      description: [''],
      platforms: this.fb.array([]),
      genres: this.fb.array([]),
      file: [null]
    });

    this.gameService.getPlatforms().subscribe((platforms: any[]) => {
      this.platforms = platforms;
      this.addCheckboxes('platforms', this.platforms);
    });
    // console.log(this.platforms);
    this.gameService.getGenres().subscribe((genres: any[]) => {
      this.genres = genres;
      this.addCheckboxes('genres', this.genres);
    });
  }

  private addCheckboxes(controlName: string, items: any[]) {
    const formArray = this.addform.get(controlName) as FormArray;
    items.forEach(() => formArray.push(this.fb.control(false)));
  }

  onSubmit() {
    const selectedPlatforms = this.addform.value.platforms
      .map((checked: boolean, i: number) => checked ? this.platforms[i].id : null)
      .filter((v: any)=> v !== null);
    const selectedGenres = this.addform.value.genres
      .map((checked: boolean, i: number) => checked ? this.genres[i].id : null)
      .filter((v: any) => v !== null);
    const formData = {
      name: this.addform.value.name,
      date: this.addform.value.date,
      description: this.addform.value.description,
      platforms: selectedPlatforms,
      genres: selectedGenres,
      file: this.addform.value.file,
    };
    this.gameService.addGame(formData).subscribe({
      next: response => {
          console.log('Added the game successfully', response);
          this.message = "Added the game successfuly";
      },
      error: error => {
          console.error('Error adding the game:', error)
          this.message = "Something went wrong. Try again";
      }
  });
}
}