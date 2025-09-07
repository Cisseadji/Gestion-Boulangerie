import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LivraisonsClientComponent } from './livraisons-client.component';

describe('LivraisonsClientComponent', () => {
  let component: LivraisonsClientComponent;
  let fixture: ComponentFixture<LivraisonsClientComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [LivraisonsClientComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(LivraisonsClientComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
