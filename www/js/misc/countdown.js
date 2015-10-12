(function(W, D) {
	var countDownFunc = W['countDown'] = function(o) {
		return new countDown(o);
	};

	// 计时器对象
	var countDown = function(o) {
		this.countType = o.countType;// 支持两种计时方式，一种是在两个日期间计时，一种基于秒数计时
		this.timerId;// 计时器ID
		this.endTime = o.endTime;// 计时器结束时间
		this.startTime = o.startTime;// 计时器开始时间
		this.timeLeft = o.timeLeft;// 计时剩余秒数，区别于上面时间段的计时方式
		this.timePassed = 0;
		this.dom = D.getElementById(o.domId);// 显示计时器的dom
		this.step = o.step;// 计时步长，以秒为单位
		this.flag = o.flag;// 是否是正向计时
		this.counter = 0;// 累加器

		// 参数校验

		if (this.endTime && this.startTime && this.timeLeft) {
			console.log("只能设置一种计时参数");
			return;
		}

		if (!this.countType) {
			console.log("必须设置计时类型，date为起始日期计时，seconds是以相差的秒数计时");
		} else {
			if (this.countType == "date") {
				if (!this.endTime || !this.startTime) {
					console.log("date类型计时必须设置起止日期");
					return;
				}
			} else if (this.countType == "seconds") {
				if (!this.timeLeft && this.timeLeft != 0) {
					console.log("seconds类型计时必须间隔的秒数");
					return;
				}
			}
			this.refrenshTime(true);// 初始化
		}

	};

	countDown.prototype = {
		auto : function() {// 周期启动刷新时间
			var self = this;
			timerId = setTimeout(function() {
				if (self.timePassed <= 0 && !self.flag) {// 倒计时到0停止计时
					self.pause();
					return;
				}
				self.refrenshTime(true);
			}, 1000 * self.step);
		},
		ten : function(t) {// 一位数补零
			if (t < 10) {
				t = "0" + t;
			}
			return t;
		},
		refrenshTime : function(isStart) {// 刷新
			var self = this, time = 0;
			var countType = self.countType;// 根据不同的计时方式计算时间差
			if (self.flag) {
				if (countType == "date") {
					self.timePassed = (new Date(self.endTime).getTime()
							- new Date(self.startTime).getTime() + self.step
							* 1000 * self.counter++) / 1000;
				} else if (countType == "seconds") {
					self.timePassed = (self.timeLeft * 1000 + self.step * 1000
							* self.counter++) / 1000;
				}
			} else {
				if (countType == "date") {
					self.timePassed = (new Date(self.endTime).getTime()
							- new Date(self.startTime).getTime() - self.step
							* 1000 * self.counter++) / 1000;
				} else if (countType == "seconds") {
					self.timePassed = (self.timeLeft * 1000 - self.step * 1000
							* self.counter++) / 1000;
				}
			}
			var day = self.ten(Math.floor(self.timePassed / (60 * 60 * 24))), hour = self
					.ten(Math.floor(self.timePassed / (60 * 60)) - day * 24), minute = self
					.ten(Math.floor(self.timePassed / 60) - (day * 24 * 60)
							- (hour * 60)), second = self.ten(Math
					.floor(self.timePassed)
					- (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60));
			self.dom.innerHTML = "<b>" + day + "天</b><b >" + hour
					+ "小时</b><b >" + minute + "分钟</b><b>" + second + "秒</b>";
			if (isStart)// 是否开始计时
				self.auto();
		},
		pause : function() {
			clearTimeout(timerId);
		},
		reset : function() {
			this.counter = 0;
			clearTimeout(timerId);
			this.refrenshTime(false);
		},
		start : function() {
			clearTimeout(timerId);
			this.refrenshTime(true);
		}
	}
})(window, document);

