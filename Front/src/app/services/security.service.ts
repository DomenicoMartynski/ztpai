import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class SecurityService {
    private loginAPI= 'http://localhost:8000/api/login';
    private registerAPI = 'http://localhost:8000/api/register';

    constructor(private http: HttpClient) { }

    loginUser(User: any): Observable<any> {
      const options = {
        headers: {
          'Content-Type': 'application/json',
          // Add any other headers if needed
        },
        mode: 'no-cors', // Set request mode to 'no-cors'
      };
      return this.http.post<any>(`${this.loginAPI}`, User, options).pipe(
          catchError(error => {
              console.error('Error loggin user:', error);
              return throwError(()=> new Error('Invalid credentials.'));
          })
      );
    }

    registerUser(newUser: any): Observable<any> {
        const headers = { 'Content-Type': 'application/ld+json' };

        return this.http.post<any>(`${this.registerAPI}`, newUser, { headers }).pipe(
            catchError(error => {
                console.error('Error adding user:', error);
                return throwError(()=> new Error('Failed to register. The email may be used.'));
            })
        );
    }
}