import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Poster} from "../../../shared/models/poster/poster";
import {Actor} from "../../../shared/models/actor/actor";

@Injectable({
  providedIn: 'root'
})
export class ActorService {

  baseUrl = 'http://localhost:8000/api/actor';

  constructor(
    private http: HttpClient,
  ) { }

  getPopular(){
    return this.http.get<Actor[]>(`${this.baseUrl}/popular`);
  }

}
