import {Component, ElementRef, OnInit, ViewChild} from '@angular/core';
import {PackService} from "../../../core/services/pack/pack.service";
import {Router} from "@angular/router";

@Component({
  selector: 'app-payment',
  templateUrl: './payment.component.html',
  styleUrls: ['./payment.component.scss']
})
export class PaymentComponent implements OnInit {

  lstPack: any;


  constructor(
    private Pack : PackService,
    private router: Router,
  ) {
  }

  ngOnInit(): void {

    this.Pack.getAll().subscribe(
      data => this.lstPack = data,
    )
  }


  onPayment(id : number) {
    this.router.navigateByUrl(`/payment/${id}`);
  }
}
