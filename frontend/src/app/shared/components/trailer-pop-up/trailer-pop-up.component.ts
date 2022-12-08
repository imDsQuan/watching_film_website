import {Component, Inject, OnInit} from '@angular/core';
import {MAT_DIALOG_DATA} from "@angular/material/dialog";

@Component({
  selector: 'app-trailer-pop-up',
  templateUrl: './trailer-pop-up.component.html',
  styleUrls: ['./trailer-pop-up.component.scss']
})
export class TrailerPopUpComponent implements OnInit {

  constructor(@Inject(MAT_DIALOG_DATA) public data: {url: string}) { }

  ngOnInit(): void {
  }

}
