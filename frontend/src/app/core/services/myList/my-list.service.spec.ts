import { TestBed } from '@angular/core/testing';

import { MyListService } from './my-list.service';

describe('MyListService', () => {
  let service: MyListService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MyListService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
