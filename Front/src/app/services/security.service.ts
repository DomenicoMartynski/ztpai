import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class SecurityService {
    private loginAPI= 'http://localhost/api/login';
    private registerAPI = 'http://localhost/api/register';

    constructor(private http: HttpClient) { }

    loginUser(User: any): Observable<any> {
      const headers = { 'Content-Type': 'application/ld+json' };

      return this.http.post<any>(`${this.loginAPI}`, User, { headers }).pipe(
          catchError(error => {
              console.error('Error adding user:', error);
              return throwError(()=> new Error('Failed to add user.'));
          })
      );
    }

    registerUser(newUser: any): Observable<any> {
        const headers = { 'Content-Type': 'application/ld+json' };

        return this.http.post<any>(`${this.registerAPI}`, newUser, { headers }).pipe(
            catchError(error => {
                console.error('Error adding user:', error);
                return throwError(()=> new Error('Failed to add user.'));
            })
        );
    }
}