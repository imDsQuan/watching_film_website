import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Actor} from "../../../shared/models/actor/actor";
import {AuthService} from "../auth/auth.service";
import {Poster} from "../../../shared/models/poster/poster";

@Injectable({
  providedIn: 'root'
})
export class MyListService {

  baseUrl = 'http://localhost:8000/api/myList';

  constructor(
    private http: HttpClient,

  ) { }


  addToList(data: any) {
    return this.http.post(`${this.baseUrl}/addToList`, data);
  }

  removeFromList(data: any) {
    return this.http.post(`${this.baseUrl}/remove`, data);
  }

  getAll(data: any) {
    return this.http.post<Poster[]>(`${this.baseUrl}/getAll`, data);
  }
}
