import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class NotificationService {

  baseUrl = 'http://localhost:8000/api';

  constructor(
    private http: HttpClient,

  ) { }


  getUnreadNoti(data : any){
    return this.http.post(`${this.baseUrl}/get-notification`, data);
  }

  markAsRead(data: any) {
    return this.http.post(`${this.baseUrl}/mark-as-read`, data)
  }
}
