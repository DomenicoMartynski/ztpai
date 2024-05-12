import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { AbstractControl,
  FormBuilder,
  FormGroup,
  FormControl,
  Validators,
  ReactiveFormsModule,
} from '@angular/forms';

import { SecurityService } from '../services/security.service';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './login.component.html',
  styleUrls: ['../home/home.component.css', './login.component.css']
})
export class LoginComponent {

  loginForm: FormGroup = new FormGroup({
    email: new FormControl(''),
    password: new FormControl(''),
  });
submitted = false;
data: string = "";

constructor(
    private securityService: SecurityService,
    private formBuilder: FormBuilder,
) { }


ngOnInit(): void {
    this.loginForm = this.formBuilder.group(
        {
            email: ['', [Validators.required, Validators.pattern("^[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,4}$")]],
            password: [
            '',
            [
                Validators.required,
                Validators.minLength(4),
                Validators.maxLength(40),
            ],
            ],
        }
    );
}

get form(): { [key: string]: AbstractControl } {
    return this.loginForm.controls;
}


submitForm(): void {
    this.submitted = true;

    if (this.loginForm.invalid) {
        return;
    }

    const formData = {
        email: this.loginForm.value.email,
        password: this.loginForm.value.password,
    }

    console.log(JSON.stringify(this.loginForm.value, null, 2));
    console.log((formData));
    
    this.securityService.loginUser(formData).subscribe({
        next: response => {
            console.log('Logged in successfully:', response)
            this.data = "Logged in successfully. Your Id: " + response.userId;
        },
        error: error => {
            console.error('Error logging in:', error)
        }
    });

}

}
