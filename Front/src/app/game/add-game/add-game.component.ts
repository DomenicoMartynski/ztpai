import { Component,  ElementRef, ViewChild  } from '@angular/core';
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
  @ViewChild('fileInput') fileInput?: ElementRef;
  addform: FormGroup;
  platforms: any[] = []; // Populate this with your platforms data
  genres: any[] = []; // Populate this with your genres data
  message: string = '';

  constructor(private fb: FormBuilder, private gameService: GameService) {
    this.addform = this.fb.group({});
  }

  ngOnInit() {
    this.addform = this.fb.group({
      name: [''],
      date: [''],
      description: [''],
      platforms: this.fb.array(this.platforms.map(() => this.fb.control(false))),
      genres: this.fb.array(this.genres.map(() => this.fb.control(false)))
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

  submitForm(event: Event){
    event.preventDefault();
    const file = this.fileInput?.nativeElement.files[0];
    const selectedPlatforms = this.addform.value.platforms
      .map((checked: boolean, i: number) => checked ? this.platforms[i].id : null)
      .filter((v: any)=> v !== null);
    const selectedGenres = this.addform.value.genres
      .map((checked: boolean, i: number) => checked ? this.genres[i].id : null)
      .filter((v: any) => v !== null);

    const formData = new FormData();
    formData.append('name', this.addform.value.name);
    formData.append('date', this.addform.value.date);
    formData.append('description', this.addform.value.description);
    formData.append('platforms', JSON.stringify(selectedPlatforms)); // Convert arrays/objects to JSON strings
    formData.append('genres', JSON.stringify(selectedGenres));

    if (file) {
      formData.append('image', file);
    }
    console.log(formData);

    formData.forEach((value, key) => {
      console.log(key, value);
    });
    
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