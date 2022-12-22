import { Component, OnInit } from '@angular/core';
import {ApiService} from "../../../../core/services/auth/api/api.service";
import {ToastrService} from "ngx-toastr";

@Component({
  selector: 'app-request-reset',
  templateUrl: './request-reset.component.html',
  styleUrls: ['./request-reset.component.scss']
})
export class RequestResetComponent implements OnInit {
  public form = {
    email: null,
  };

  constructor(
    private Api: ApiService,
    private toastr: ToastrService,
  ) { }

  ngOnInit(): void {
  }

  onSubmit() {
    this.toastr.info('Wait...')
    this.Api.sendPasswordResetLink(this.form).subscribe(
      data => this.handleResponse(data),
      error => this.toastr.error(error.error.error)
    )
  }

  handleResponse(res : any) {
    this.toastr.success(res.data);
    this.form.email = null;
  }

}
