pkg load control

arguments = argv();
r= str2double(arguments{1});
lastPos = str2double(arguments{2});

function ret = car(r, lastPos)

m1 = 2500; m2 = 320;
k1 = 80000; k2 = 500000;
b1 = 350; b2 = 15020;
A=[0 1 0 0;-(b1*b2)/(m1*m2) 0 ((b1/m1)*((b1/m1)+(b1/m2)+(b2/m2)))-(k1/m1) -(b1/m1);b2/m2 0 -((b1/m1)+(b1/m2)+(b2/m2)) 1;k2/m2 0 -((k1/m1)+(k1/m2)+(k2/m2)) 0];
B=[0 0;1/m1 (b1*b2)/(m1*m2);0 -(b2/m2);(1/m1)+(1/m2) -(k2/m2)];
C=[0 0 1 0]; D=[0 0];
Aa = [[A,[0 0 0 0]'];[C, 0]];
Ba = [B;[0 0]];
Ca = [C,0]; Da = D;
K = [0 2.3e6 5e8 0 8e6];
sys = ss(Aa-Ba(:,1)*K,Ba,Ca,Da);

t = 0:0.01:5;
initX1 = lastPos;
initX1d = 0;
initX2 = 0;
initX2d = 0;
[y,t,x]=lsim(sys*[0;1],r*ones(size(t)),t,[initX1;initX1d;initX2;initX2d;0]);
plot(t,y)

ret = [x(:,1), x(:,3)];

endfunction

disp(car(r, lastPos));