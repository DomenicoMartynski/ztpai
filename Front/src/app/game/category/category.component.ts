import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
@Component({
  selector: 'app-category',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './category.component.html',
  styleUrls: ['../gamedetails/gamedetails.component.css', '../../home/home.component.css','./category.component.css']
})
export class CategoryComponent {

}
