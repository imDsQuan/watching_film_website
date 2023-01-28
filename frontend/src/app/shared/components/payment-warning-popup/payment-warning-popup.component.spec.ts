import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PaymentWarningPopupComponent } from './payment-warning-popup.component';

describe('PaymentWarningPopupComponent', () => {
  let component: PaymentWarningPopupComponent;
  let fixture: ComponentFixture<PaymentWarningPopupComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PaymentWarningPopupComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(PaymentWarningPopupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
