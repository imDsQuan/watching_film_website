import {Component, ElementRef, OnInit, ViewChild} from '@angular/core';
import {PackService} from "../../../../core/services/pack/pack.service";
import {User} from "../../../../shared/models/user/User";
import {UserService} from "../../../../core/services/auth/user/user.service";
import {ActivatedRoute, Router} from "@angular/router";
import {HttpClient} from "@angular/common/http";
import {Toast, ToastrService} from "ngx-toastr";

@Component({
  selector: 'app-payment-detail',
  templateUrl: './payment-detail.component.html',
  styleUrls: ['./payment-detail.component.scss']
})
export class PaymentDetailComponent implements OnInit {
  @ViewChild('paypal', {static: true}) paypalElement: ElementRef | undefined

  pack: any;
  currUser ?: User;

  payeeEmail: string = 'sb-uk47fa23459686@business.example.com';

  paypalConfig = {//Configuration for paypal Smart Button
    createOrder: (data : any, actions: any) => {
      const user_id = this.currUser?.id;
      return actions.order.create({
        purchase_units: [{
          description: this.pack?.title,
          user_id: user_id,
          amount: {
            currency_code: 'USD',
            value: this.pack?.price
          }, payee: {
            email_address: this.payeeEmail
          }, custom: JSON.stringify(this.currUser)
        }]
      });
    },
    onApprove: async (data : any, actions : any) => {
      const order = await actions.order.capture();
      order.user = this.currUser;
      order.pack = this.pack;
      console.log(order);
      this.http
        .post('http://localhost:8000/api/paypal/checkout', order).subscribe(
            data => this.handleResponse(data),
        )

    },
    onError: (err: any) => {
      console.log(err)
    }
  }

  handleResponse(data: any) {
    // @ts-ignore
    this.currUser.subscription = data.data.subscription;
    // @ts-ignore
    this.currUser.pack = data.data.pack;
    this.User.set(this.currUser);
    this.toastr.success('Subscription Payment Successfully!')
    this.router.navigateByUrl('');
    window.location.href='http://localhost:4200/';
  }


  constructor(
    private Pack: PackService,
    private User: UserService,
    private route: ActivatedRoute,
    private http: HttpClient,
    private router: Router,
    private toastr: ToastrService,
  ) { }

  ngOnInit(): void {
    // @ts-ignore
    paypal.Buttons(this.paypalConfig).render(this.paypalElement.nativeElement)

    this.currUser = this.User.get();
    this.Pack.getPack(this.route.snapshot.paramMap.get('id')).subscribe(
      data => {
        this.pack = data;
      },
    )
  }

  onPayment(id : number) {

  }
}
