import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Actor} from "../../../shared/models/actor/actor";

@Injectable({
  providedIn: 'root'
})
export class PackService {

  baseUrl = 'http://localhost:8000/api/pack';

  constructor(
    private http: HttpClient,
  ) { }

  getAll(){
    return this.http.get(`${this.baseUrl}/getAll`);
  }

  getPack(id: string | null) {
    let data = {
      id: id,
    }
    return this.http.post(`${this.baseUrl}/getPack`, data);
  }
}
