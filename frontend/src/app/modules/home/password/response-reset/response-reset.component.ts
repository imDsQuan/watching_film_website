import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {ApiService} from "../../../../core/services/auth/api/api.service";
import {ToastrService} from "ngx-toastr";

@Component({
  selector: 'app-response-reset',
  templateUrl: './response-reset.component.html',
  styleUrls: ['./response-reset.component.scss']
})
export class ResponseResetComponent implements OnInit {
  public form = {
    password: null,
    email: null,
    password_confirmation: null,
    resetToken : null,
  };

  public error = {
    email: null,
    password: null,
  };

  constructor(
    private route: ActivatedRoute,
    private Api : ApiService,
    private toastr: ToastrService,
    private router: Router,
  ) {
    route.queryParams.subscribe(params => {
      this.form.resetToken = params['token'];
    })
  }

  ngOnInit(): void {
  }

  onSubmit() {
    this.Api.changePassword(this.form).subscribe(
      data => this.handleResponse(data),
      error => this.handleError(error),
    )
  }

  handleResponse(data : any) {
    this.toastr.success(data.data);
    this.router.navigateByUrl('/login');
  }

  handleError(error : any) {
    this.error = error.error.errors;
  }
}
