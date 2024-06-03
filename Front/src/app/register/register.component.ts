import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { AbstractControl,
  FormBuilder,
  FormGroup,
  FormControl,
  Validators,
  ReactiveFormsModule,
} from '@angular/forms';

import Validation from '../utils/validation';
import { SecurityService } from '../services/security.service';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './register.component.html',
  styleUrl: './register.component.css'
})

export class RegisterComponent {
  registerForm: FormGroup = new FormGroup({
        username: new FormControl(''),
        email: new FormControl(''),
        password: new FormControl(''),
        confirmPassword: new FormControl(''),
    });
    submitted = false;
    data: string = "";

    constructor(
        private securityService: SecurityService,
        private formBuilder: FormBuilder,
    ) { }


    ngOnInit(): void {
        this.registerForm = this.formBuilder.group(
            {
                username: ['', Validators.required],
                email: ['', [Validators.required, Validators.pattern("^[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,4}$")]],
                password: [
                '',
                [
                    Validators.required,
                    Validators.minLength(4),
                    Validators.maxLength(40),
                ],
                ],
                confirmPassword: ['', Validators.required],
            },
            {
                validators: [Validation.match('password', 'confirmPassword')],
            }
        );
    }

    get form(): { [key: string]: AbstractControl } {
        return this.registerForm.controls;
    }


    submitForm(): void {
        this.submitted = true;

        if (this.registerForm.invalid) {
            return;
        }

        const formData = {
            username: this.registerForm.value.username,
            email: this.registerForm.value.email,
            password: this.registerForm.value.password,
        }

        
        this.securityService.registerUser(formData).subscribe({
            next: response => {
                console.log('Registered successfully:', response)
                this.data = "Registered successfuly";
            },
            error: error => {
                console.error('Error registering:', error)
            }
        });

    }

}
